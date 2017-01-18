<?php
class Database{
	public $result;
	private $db;
	private $d;
	private $query;

	public function __construct($d)
		{
		//echo $d['action'];
		$this->result=[	'status'=>'error','status_extend'=>'init','payload'=>[],'message'=>'База данных: Подключение не выполнено'];

		$this->d=[
			'id'=>(int)$d['id'],
			'sessionId'	=>empty((int)$d['sessionId'])? '-1': (int)$d['sessionId'],
			'table'		=>mb_eregi_replace('[^A-Za-z]+$','',$d['table']),
			'action'	=>mb_eregi_replace('[^A-Za-z]+$','',$d['action']),
			'userEmail'	=>mb_eregi_replace('[^A-Za-z\._\-@]+$','',$d['userEmail']),
			'newsTitle'	=>RCe::encode($d['newsTitle']),
			'newsMessage'	=>RCe::encode($d['newsMessage'])
			];

		$this->db	= $this->connect();

		switch($this->d['action'])
			{
			case 'Table':
				$this->query	= $this->Table();
			break;
			case 'PostNews':
				$this->query	= $this->PostNews();
			break;
			case 'SessionSubscribe':
				$this->query	= $this->SessionSubscribe();
			break;
			}
		$this->db->close();
		}
	private function connect()
		{
		$ret = new mysqli(RCe::db()['host'], RCe::db()['user'], RCe::db()['password'], RCe::db()['database']);
		if($ret)
			{
			$ret->set_charset("utf8");
			}
		else
			{
			$this->result=["status"=>'error',"payload"=>[],"message"=>'База данных: Ошибка подключения'];
			return false;
			}
		return $ret;
		}
	private function Table()
		{
		if(empty($this->d['id']))
			{
			if($this->d['table']=="News")
				{
				$where=' WHERE active=1';
				}
			$select = $this->db->query('SELECT * FROM '.$this->d['table'].$where);
			}
		else
			{
			if($this->d['table']=="News")
				{
				$where=' WHERE active=1 AND id='.(int)$this->d['id'];
				}
			else
				{
				$where=' WHERE id='.(int)$this->d['id'];
				}
			$select = $this->db->query('SELECT * FROM '.$this->d['table'].$where);
			}
		if($select->num_rows>0)
			{
			$x=0;
			while($row=$select->fetch_assoc())
				{
				$res[$x]=$row;
				$res[$x]['newsMessage']=RCe::decode($row['newsMessage']);
				$res[$x]['newsTitle']=RCe::decode($row['newsTitle']);
				$x++;
				}
			$this->result=["status"=>'ok',"payload"=>$res,];
			}
		else
			{
			$this->result=["status"=>'error',"payload"=>[],"message"=>'База данных: Ошибка обработки запроса'];
			return false;
			}
		return $select;
		}
	private function PostNews()
		{
		if($part_id=$this->db->query('(SELECT `ID` FROM `Participant` WHERE `Email` LIKE "'.$this->d['userEmail'].'")'))
			{
//			print_r($part_id);
			if($part_id->num_rows==1)
				{
				$participant_id=$part_id->fetch_assoc()['ID'];
				}
			else
				{
				$this->result=["status"=>'error','ext_staus'=>'participant_not_found' ,"message"=>'База данных: Не найден пользователь'];
				return false;
				}
			}
		else
			{
			$this->result=["status"=>'error','ext_staus'=>'connect_participant_table_failed' ,"message"=>'База данных: Не найден пользователь'];
			return false;
			}
		
		$record_hash=md5($participant_id.$this->d['newsTitle'].$this->d['newsMessage']);

		$insert=$this->db->query('INSERT INTO `News` 
					(`ParticipantId`, `NewsTitle`, `NewsMessage`, `non_unique_hash`) 
				VALUES 
					('.$participant_id.', "'.$this->d['newsTitle'].'", "'.$this->d['newsMessage'].'", "'.$record_hash.'")');
		if($insert===true)
			{
			if($this->db->insert_id>0)
				{
				$select="SELECT ID, count(*) AS rec_count";
				$from=" FROM News";
				$where=' WHERE `ParticipantId`='.$participant_id.' AND `non_unique_hash`="'.$record_hash.'"';
				$group_by=' GROUP BY non_unique_hash';
				if($rec_count=$this->db->query($select.$from.$where.$group_by))
					{
					$rec_count_f=$rec_count->fetch_assoc();
					if($rec_count_f['rec_count']>1)
						{
						$this->result=["status"=>'ok','ext_staus'=>'non_unique' ,"message"=>'Ваша новость не является уникальной и сохранена в черновики.'];
						}
					else
						{	
						$this->result=["status"=>'ok' ,'ext_staus'=>'unique' ,"message"=>'Спасибо, ваша новость сохранена'];
						if($this->db->query('UPDATE News SET active=1 WHERE ID='.$rec_count_f['ID']))
							{
							$this->result=["status"=>'ok' ,'ext_staus'=>'unique_and_active' ,"message"=>'Спасибо, ваша новость сохранена'];
							}
						else
							{
							$this->result=["status"=>'ok' ,'ext_staus'=>'unique_and_not_active' ,"message"=>'Спасибо, ваша новость сохранена в черновики'];
							}
						}
					}
				else
					{
					$this->result=["status"=>'error','ext_staus'=>'unique_check_error' ,"message"=>'База данных: Ошибка обработки запроса 171 сервером баз данных'];
					}
				}
			else
				{
				$this->result=["status"=>'error','save_status'=>'db_error' ,"message"=>'Ошибка БД: новость не сохранена <cut>'.RCe::decode($this->d['newsTitle']).'<br/><br/>'.RCe::decode($this->d['newsMessage']).'</cut>'];
				}
			}
		else
			{
			$this->result=["status"=>'error','ext_status'=>'db_error' ,"message"=>'База данных: Ошибка обработки запроса сервера баз данных'];
			}
		}
	private function SessionSubscribe()
		{
		$subscribe = $this->db->query('UPDATE `Spot` SET `UserId`=(SELECT `ID` FROM `User` WHERE `Email` LIKE "'.$this->d['userEmail'].'") WHERE `SessionId`='.(int)$this->d['sessionId'].' AND `UserId` IS null LIMIT 1');
		if($subscribe===true)
			{
			if($this->db->affected_rows===1)
				{
				$this->result=["status"=>'ok',"status_extend"=>'filled',"message"=>'Спасибо, вы успешно записаны'];
				//$this->db->query('INSERT INTO `Log`(`email`,`name`) VALUES ("'.$this->d['userEmail'].'",(SELECT `Name` FROM `User` WHERE `Email` LIKE "'.$this->d['userEmail'].'"))');
				}
			else
				{
				if($this->db->query('SELECT `ID` FROM `User` WHERE `Email` LIKE "'.$this->d['userEmail'].'"')->num_rows>0)
					{
					$this->result=["status"=>'ok',"status_extend"=>'fullfilled',"message"=>'Извините, все места заняты'];
					}
				else
					{
					$this->result=["status"=>'error',"status_extend"=>'noSuchUser',"message"=>'Операция отменена. Пользователя с емейлом '.$this->d['userEmail'].' нет в базе данных'];
					}
				}
			}
		else
			{
			$this->result=["status"=>'error' ,"message"=>'База данных: Ошибка обработки запроса сервера баз данных'];
			return false;
			}
			return $subscribe;
		}
}
?>