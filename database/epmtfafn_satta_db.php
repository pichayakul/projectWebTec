<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
<?php
/**
*  Database
*/
class Database
{


	//  SET PROPERTY
	private $servername = "localhost";
	// private $username = "epmtfafn_satta";
	// private $password = "satta123";
	private $username = "root";
	private $password = "";
	private $dbname = "epmtfafn_satta";
	private $conn = null; //  connect database


	/********************************************************************************/
			/* OPEN AND CLOSE DATABASE */
	/********************************************************************************/

	/**
	*  Open database
	*/
	public function openDatabase() {
		try
		{
		  $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
		 	$this->conn->exec("set names utf8");
		  // set the PDO error mode to exception
	    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  }
		catch(PDOException $e)
		{
		  echo "Connection failed: " . $e->getMessage();
		}
	}


	/**
	*  Close database
	*/
	public function closeDatabase() {
		$this->conn = null;
	}


/********************************************************************************/
			/* EVENT */
	/********************************************************************************/

	/**
	*  Get event from event number (only one)
	*  @return Array
						(
							[noevent] =>
							[username] =>
							[name] =>
							[type] =>
							[current] =>
							[capacity] =>
							[price] =>
							[image_path] =>
							[vdo_path] =>
							[description] =>
							[create_date_time] =>
							[start_date_time] =>
							[end_date_time] =>
							[location] =>
							[condition] =>
							[status] =>
						)
	*/
	public function get_noevent($noevent) {
		try {
			$ret = array();
			$statement = $this->conn->prepare('SELECT * FROM event WHERE noevent=:noevent' );
			$statement->execute([':noevent' => $noevent]); //  set no event
			$ret = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all and get array
			return $ret;
		} catch (PDOException $e) {
			echo "ERROR get_noevent($noevent)";
		}
	}
	public function add_eventmember($noevent,$username,$request_date_time,$payment_path,$pre_path,$tickets) {
		$statement = $this->conn->prepare('INSERT INTO eventmember VALUES (:noevent,:username,"requested",:request_date_time,join_date_time="0000-00-00 00:00:00",:payment_path,:pre_path,qrcode=0,:tickets)');
		$statement->execute([':noevent' => $noevent,
												':username' => $username,
												':request_date_time' => $request_date_time,
												':payment_path' => $payment_path,
												':pre_path' => $pre_path,
												':tickets' => $tickets]); //  set no event


	}
	public function update_eventmember($noevent,$username,$request_date_time,$payment_path,$pre_path,$tickets) {
		$statement = $this->conn->prepare('UPDATE eventmember SET request_date_time=:request_date_time,payment_path=:payment_path,pre_path=:pre_path,tickets=:tickets where username=:username and noevent=:noevent');
		$statement->execute([':noevent' => $noevent,
												':username' => $username,
												':request_date_time' => $request_date_time,
												':payment_path' => $payment_path,
												':pre_path' => $pre_path,
												':tickets' => $tickets]); //  set no event


	}
	public function get_event_noevent($noevent){
		try {
			$ret = array();
			$statement = $this->conn->prepare('SELECT * FROM event WHERE noevent=:noevent' );
			$statement->execute([':noevent' => $noevent]); //  set no event
			$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all and get array
			return $ret;
		} catch (PDOException $e) {
			echo "ERROR get_noevent($noevent)";
		}
	}



	public function get_event_username($username) {
		try {
			$ret = array();
			$statement = $this->conn->prepare('SELECT * FROM event WHERE username=:username' );
			$statement->execute([':username' => $username]); //  set no event
			$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all and get array
			return $ret;
		} catch (PDOException $e) {
			echo "ERROR get_noevent($noevent)";
		}
	}


	/**
	*  Get all event
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[name] =>
								[type] =>
								[current] =>
								[capacity] =>
								[price] =>
								[image_path] =>
								[vdo_path] =>
								[description] =>
								[create_date_time] =>
								[start_date_time] =>
								[end_date_time] =>
								[location] =>
								[condition] =>
								[status] =>
							)
							...
						)
	*/
	public function get_event_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="event"');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function get_event_sort_desc_alive() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="event" AND status=0 ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function get_event_sort_desc_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="event" ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all seminar
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[name] =>
								[type] =>
								[current] =>
								[capacity] =>
								[price] =>
								[image_path] =>
								[vdo_path] =>
								[description] =>
								[create_date_time] =>
								[start_date_time] =>
								[end_date_time] =>
								[location] =>
								[condition] =>
								[status] =>
							)
							...
						)
	*/
	public function get_seminar_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="seminar"');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function get_seminar_sort_desc_alive() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="seminar" AND status=0 ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function get_seminar_sort_desc_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="seminar" ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all event
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[name] =>
								[type] =>
								[current] =>
								[capacity] =>
								[price] =>
								[image_path] =>
								[vdo_path] =>
								[description] =>
								[create_date_time] =>
								[start_date_time] =>
								[end_date_time] =>
								[location] =>
								[condition] =>
								[status] =>
							)
							...
						)
	*/
	public function get_event_and_seminar_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}

	public function get_event_and_seminar_sort_desc_alive() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE status=0 ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function get_event_and_seminar_sort_desc_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event ORDER BY current DESC');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all event
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[name] =>
								[type] =>
								[current] =>
								[capacity] =>
								[price] =>
								[image_path] =>
								[vdo_path] =>
								[description] =>
								[create_date_time] =>
								[start_date_time] =>
								[end_date_time] =>
								[location] =>
								[condition] =>
								[status] =>
							)
							...
						)
	*/
	public function get_event_available_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="event" AND status=0');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all seminar
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[name] =>
								[type] =>
								[current] =>
								[capacity] =>
								[price] =>
								[image_path] =>
								[vdo_path] =>
								[description] =>
								[create_date_time] =>
								[start_date_time] =>
								[end_date_time] =>
								[location] =>
								[condition] =>
								[status] =>
							)
							...
						)
	*/
	public function get_seminar_available_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM event WHERE type="seminar" AND status=0');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all member of that event
	*  @return Array
						(
							[0] => Array
							(
								[noevent] =>
								[username] =>
								[status] =>
								[request_date_time] =>
								[join_date_time] =>
								[payment_path] =>
								[pre_path] =>
							)
							...
						)
	*/
	public function get_eventmember_all($noevent) {
		$ret = array();
		$statement = $this->conn->prepare('SELECT * FROM eventmember WHERE noevent=:noevent');
		$statement->execute([':noevent' => $noevent]); //  set no event
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all and get array
		return $ret;
	}
	/**
	*  Confirmation (Accepted) member as requested
	*  @param event number amd username
	*/
	public function confirm_eventmember($noevent, $username) {
		$query = 'UPDATE eventmember SET status="accepted" WHERE noevent=:noevent AND username=:username';
		$statement = $this->conn->prepare($query);
		$statement->execute([':noevent' => $noevent, ':username' => $username]); //  set no event
	}
	public function pass_event_eventmember($noevent, $username,$date) {
		$query = 'UPDATE eventmember SET status="completed",join_date_time=:date WHERE noevent=:noevent AND username=:username';
		$statement = $this->conn->prepare($query);
		$statement->execute([':noevent' => $noevent, ':username' => $username,':date'=> $date]); //  set no event
	}

	public function decline_eventmember($noevent, $username) {
		$query = 'DELETE from  eventmember WHERE noevent=:noevent AND username=:username';
		$statement = $this->conn->prepare($query);
		$statement->execute([':noevent' => $noevent, ':username' => $username]); //  set no event
	}


	/**
	*  Creation event
	*  @param event number
						username
						name
						type ("seminar" or "event")
						current (number of member in event)
						capacity (max member in event)
						price (cost of ticket)
						image_path (many image path seperate with ";")
						vdo_path (many video path seperate with ";")
						description (desctiption for purpose text only)
						date time (use DateTimePicker)
						location (coordinates)
						condition (pre-require of event)
	*/
	public function create_event($username,$name,$type,$current,$capacity,$price,
															$image_path,$vdo_path,$description,$create_date_time,
															$start_date_time,$end_date_time,$location,$pre_condition,$status,$qrcode,$lat,$lon,$linkF) {
		$noevent = 0;
		$statement = $this->conn->prepare('INSERT INTO event VALUES (:noevent,:username,:name,:type,:current,:capacity,:price,:image_path,
			:vdo_path,:description,:create_date_time,:start_date_time,:end_date_time,:location,:pre_condition,:status,:qrcode,:lat,:lon,:linkF)' );
		$statement->execute([':noevent' => $noevent,
												':username' => $username,
												':name' => $name,
												':type' => $type,
												':current' => $current,
												':capacity' => $capacity,
												':price' => $price,
												':image_path' => $image_path,
												':vdo_path' => $vdo_path,
												':description' => $description,
												':create_date_time' => $create_date_time,
												':start_date_time' => $start_date_time,
												':end_date_time' => $end_date_time,
												':location' => $location,
												':pre_condition' => $pre_condition,
												':status'=> $status,
												':qrcode'=> $qrcode,
											':lat' => $lat,
											':lon' => $lon,
										'linkF'=> $linkF]); //  set no event
		// $ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		$ret = $noevent;
		return $ret;
	}

	/**
	*  Creation question
	*  @param event number
						question (Sentense)
	*/
	public function create_question($noevent, $question) {
		$noquestion = $this->gene_noquestion($noevent);
		if ($noquestion <= 0) {
			return "SOMETHING WRONG, can not generate new question number.";
		}

		$statement = $this->conn->prepare('INSERT INTO event_question VALUES (:noevent,:noquestion,:question)');
		$statement->execute([':noevent'=>$noevent,':noquestion'=>$noquestion,':question'=>$question]);
	}


	/**
	*  Creation assessment
	*  @param event number
						answer (Integer)
	*/
	public function create_assessment($noevent, $answer) {
		$noassessment = $this->gene_noassessment($noevent);
		if ($noassessment <= 0) {
			return "SOMETHING WRONG, can not generate new assessment number.";
		}

		$statement = $this->conn->prepare('INSERT INTO event_assessment VALUES (:noevent,:noassessment,:answer)');
		$statement->execute([':noevent'=>$noevent,':noassessment'=>$noassessment,':answer'=>$answer]);
	}
	public function update_event($noevent,$username,$name,$type,$current,$capacity,$price,
	$image_path,$vdo_path,$description,$create_date_time,
	$start_date_time,$end_date_time,$location,$pre_condition,$lat,$lon,$link) {
	$statement = $this->conn->prepare('UPDATE event SET username=:username,name=:name,type=:type,current=:current,capacity=:capacity,price=:price,imagePath=:image_path,vdoPath=:vdo_path,description=:description,create_date_time=:create_date_time,start_date_time=:start_date_time,end_date_time=:end_date_time,location=:location,pre_condition=:pre_condition,lat=:lat,lon=:lon,formPath=:link WHERE noevent=:noevent' );
	$statement->execute([':noevent' => $noevent,
	':username' => $username,
	':name' => $name,
	':type' => $type,
	':current' => $current,
	':capacity' => $capacity,
	':price' => $price,
	':image_path' => $image_path,
	':vdo_path' => $vdo_path,
	':description' => $description,
	':create_date_time' => $create_date_time,
	':start_date_time' => $start_date_time,
	':end_date_time' => $end_date_time,
	':location' => $location,
	':pre_condition' => $pre_condition,
	':lat'=> $lat,
	':lon'=> $lon,
'link'=>$link]); //  set no event
	}


	public function update_event_finish($noevent) {
		$statement = $this->conn->prepare('UPDATE event SET status=1 WHERE noevent=:noevent');
		$statement->execute([':noevent' => $noevent]);
	}


	public function delete_event($noevent) {
		$statement = $this->conn->prepare('DELETE FROM event WHERE noevent=:noevent');
		$statement->execute([':noevent' => $noevent]);
	}


	/**
	*  Generate new question number
	*  @param event number
	*  @return new question number (Integer)
	*/
	private function gene_noquestion($noevent) {
		$ret = 0;
		$statement = $this->conn->prepare('SELECT noquestion FROM event_question WHERE noevent=:noevent' );
		$statement->execute([':noevent' => $noevent]); //  set no event
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		$size = count($arr);
		if ($size == 0) {
			$ret = 1;
		} else {
			$ret = $arr[$size-1]['noquestion']+1; //  generate topic number from last topic number
		}
		return $ret;
	}


	/**
	*  Generate new assessment number
	*  @param event number
	*  @return new assessment number (Integer)
	*/
	private function gene_noassessment($noevent) {
		$ret = 0;
		$statement = $this->conn->prepare('SELECT noassessment FROM event_assessment WHERE noevent=:noevent' );
		$statement->execute([':noevent' => $noevent]); //  set no event
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		$size = count($arr);
		if ($size == 0) {
			$ret = 1;
		} else {
			$ret = $arr[$size-1]['noassessment']+1; //  generate topic number from last topic number
		}
		return $ret;
	}


	/********************************************************************************/
			/* WEBBOARD */
	/********************************************************************************/

	/**
	*  Get topic with topic number
	*  @param topic number
	*  @return Array
						(
	            [notopic] =>
	            [noevent] =>
	            [username] =>
	            [header] =>
	            [description] =>
	            [date_time] =>
						)
	*/
	public function get_topic($notopic) {
		$ret = array();
		$statement = $this->conn->prepare('SELECT * FROM topic WHERE notopic=:notopic' );
		$statement->execute([':notopic' => $notopic]); //  set no event
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all topic of that event with event number
	*  @param event number
	*  @return Array
						(
					    [0] => Array
			        (
		            [notopic] =>
		            [noevent] =>
		            [username] =>
		            [header] =>
		            [description] =>
		            [date_time] =>
			        )
			        ...
						)
	*/
	public function get_topic_noevent_all($noevent) {
		$ret = array();
		$statement = $this->conn->prepare('SELECT * FROM topic WHERE noevent=:noevent' );
		$statement->execute([':noevent' => $noevent]); //  set no event
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	/**
	*  Get all comment of that topic with topic number
	*  @param topic number
	*  @return Array
						(
					    [0] => Array
			        (
		            [notopic] =>
		            [nocomment] =>
		            [username] =>
		            [message] =>
		            [date_time] =>
			        )
			        ...
						)
	*/
	public function get_comment_notopic_all($notopic) {
		$ret = array();
		$statement = $this->conn->prepare('SELECT * FROM comment WHERE notopic=:notopic' );
		$statement->execute([':notopic' => $notopic]); //  set no event
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}

	public function get_comment_notopic_notopic($notopic,$comment) {
	  $ret = array();
	  $statement = $this->conn->prepare('SELECT * FROM comment WHERE notopic=:notopic AND comment=:comment' );
	  $statement->execute([':notopic' => $notopic,':comment' => $comment]); //  set no event
	  $ret = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all to Array in Array
	  return $ret;
	}


	/**
	*  Creation topic
	*  @param topic number
						event number
						username
						header (name of topic)
						description (desctiption for purpose text only)
						date time (use DateTimePicker)
	*/
	public function create_topic($noevent,$username,$header,$description,$date_time) {
		$notopic = 0;
		$statement = $this->conn->prepare('INSERT INTO topic VALUES (:notopic,:noevent,
																			:username,:header,:description,:date_time)' );
		$statement->execute([':notopic' => $notopic,
												':noevent' => $noevent,
												':username' => $username,
												':header' => $header,
												':description' => $description,
												':date_time' => $date_time]); //  set no event
	}


	/**
	*  Creation comment in topic
	*  @param topic number
						comment number
						username
						message
						date time (use DateTimePicker)
	*/
	public function create_comment($notopic,$username,$message,$date_time) {
		$nocomment = $this->gene_nocomment_notopic($notopic);
		if ($nocomment <= 0) {
			//  call error handle
			return "SOMETHING WRONG, can not generate new comment number.";
		}

		$statement = $this->conn->prepare('INSERT INTO comment VALUES (:notopic,:nocomment,
																			:username,:message,:date_time)' );
		$statement->execute([':notopic' => $notopic,
												':nocomment' => $nocomment,
												':username' => $username,
												':message' => $message,
												':date_time' => $date_time]); //  set no event
	}


	public function update_topic($notopic,$noevent,$username,$header,$description,$date_time) {
	  $statement = $this->conn->prepare('UPDATE topic SET noevent=:noevent,username=:username,header=:header,description=:description,date_time=:date_time WHERE notopic=:notopic' );
	  $statement->execute([':notopic' => $notopic,
	            ':noevent' => $noevent,
	            ':username' => $username,
	            ':header' => $header,
	            ':description' => $description,
	            ':date_time' => $date_time]); //  set no event

	 }


	public function delete_topiccomment_notopic($notopic) {
		$statement = $this->conn->prepare('DELETE FROM topic WHERE notopic=:notopic');
		$statement->execute([':notopic' => $notopic]);
	}


	public function delete_comment_notopic($notopic) {
		$statement = $this->conn->prepare('DELETE FROM comment WHERE notopic=:notopic');
		$statement->execute([':notopic' => $notopic]);
	}


	public function delete_comment_notopic_nocomment($notopic,$nocomment) {

	  $statement = $this->conn->prepare('DELETE FROM comment WHERE notopic=:notopic AND nocomment=:nocomment');
	  $statement->execute([':notopic' => $notopic,':nocomment' => $nocomment]);

	 }

	/**
	*  Generate new comment number that topic
	*  @param topic number
	*  @return new comment number (Integer)
	*/
	private function gene_nocomment_notopic($notopic) {
		$ret = 0;
		$statement = $this->conn->prepare('SELECT nocomment FROM comment WHERE notopic=:notopic' );
		$statement->execute([':notopic' => $notopic]); //  set no event
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		$size = count($arr);
		if ($size == 0) {
			$ret = 1;
		} else {
			$ret = $arr[$size-1]['nocomment']+1; //  generate topic number from last topic number
		}
		return $ret;
	}


	/********************************************************************************/
			/* LOG */
	/********************************************************************************/

	/**
	*  Get all log
	*  @return Array
						(
							[0] => Array
							(
		            [nolog] =>
		            [username] =>
		            [date_time] =>
		            [action] =>
							)
							...
						)
	*/
	public function get_userLog_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM user_log');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		return $ret;
	}


	public function create_log($username, $date_time, $action) {
		$statement = $this->conn->prepare('INSERT INTO user_log VALUES (0,:username,:date_time,:action)' );
		$statement->execute([':username' => $username,':date_time' => $date_time, ':action' => $action]); //  set no event
	}


	/********************************************************************************/
			/* OTHER */
	/********************************************************************************/

	public function create_account($username,$password,$nickname,$position,$first_name,$last_name,$gender,$age,$email,$image,$start_date_time) {
		$statement = $this->conn->prepare('INSERT INTO account (username,password,nickname,position,first_name, last_name, gender, age, email, image, start_date_time, status_email, status_ban) VALUES (:username,:password,:nickname,:position,:first_name,:last_name,:gender,:age,:email,:image,:start_date_time,0,0);' );
		$statement->execute([':username' => $username,
												':password' => $password,
												':nickname' => $nickname,
												':position' => $position,
												':first_name' => $first_name,
												':last_name' => $last_name,
												':gender' => $gender,
												':age' => $age,
												':email' => $email,
												':image' => $image,
												':start_date_time' => $start_date_time]); //  set username
	}


	public function update_account($username,$password,$nickname,$position,$first_name,$last_name,
												$email,$image) {
		$statement = $this->conn->prepare('UPDATE account SET password=:password,nickname=:nickname,position=:position,first_name=:first_name,last_name=:last_name,email=:email,image=:image WHERE username=:username' );
		$statement->execute([':username' => $username,
												':password' => $password,
												':nickname' => $nickname,
												':position' => $position,
												':first_name' => $first_name,
												':last_name' => $last_name,
												':email' => $email,
												':image' => $image]); //  set username
	}
	public function update_image_account($username,$image){
		$statement = $this->conn->prepare('UPDATE account SET image=:image,username=:username WHERE username=:username' );
		$statement->execute([':username' => $username,
												':image' => $image]);
	}


	public function update_account_keyword($username, $key, $value) {
		$statement = $this->conn->prepare('UPDATE account SET username=:username WHERE username=:username');
		if ($key == 'first_name') {
			$statement = $this->conn->prepare('UPDATE account SET first_name=:value WHERE username=:username');
		} else if ($key == 'last_name') {
			$statement = $this->conn->prepare('UPDATE account SET last_name=:value WHERE username=:username');
		} else if ($key == 'nickname') {
			$statement = $this->conn->prepare('UPDATE account SET nickname=:value WHERE username=:username');
		} else if ($key == 'gender') {
			$statement = $this->conn->prepare('UPDATE account SET gender=:value WHERE username=:username');
		} else if ($key == 'age') {
			$statement = $this->conn->prepare('UPDATE account SET age=:value WHERE username=:username');
		} else if ($key == 'email') {
			$statement = $this->conn->prepare('UPDATE account SET email=:value WHERE username=:username');
		} else if ($key == 'password') {
			$statement = $this->conn->prepare('UPDATE account SET password=:value WHERE username=:username');
		} else if ($key == 'position') {
			$statement = $this->conn->prepare('UPDATE account SET position=:value WHERE username=:username');
		}
		$statement->execute([':username' => $username,':value' => $value]);
	}


	public function check_admin_account() {
		$res = 0;
		$statement = $this->conn->query('SELECT count(*) as count FROM account WHERE position="admin"');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC)[0]['count'];
		return $ret;
	}


	public function ban_account($username) {
		$statement = $this->conn->prepare('UPDATE account SET status_ban=1 WHERE username=:username');
		$statement->execute([':username' => $username]);
	}


	public function change_password($username, $password) {
		$statement = $this->conn->prepare('UPDATE account SET password=:password WHERE username=:username');
		$statement->execute([':username' => $username, ':password' => $password]);
	}


	public function infoUsername($username) {
	  $statement = $this->conn->prepare('SELECT * FROM account WHERE username=:username' );
	  $statement->execute([':username' => $username]); //  set username
	  $result = $statement->fetchAll(PDO::FETCH_ASSOC)[0]; //  fetch all to Array in Array
	  return $result;
	 }
	 public function infoUsernameCheck($username) {
 	  $statement = $this->conn->prepare('SELECT * FROM account WHERE username=:username' );
 	  $statement->execute([':username' => $username]); //  set username
 	  $result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
 	  return $result;
 	 }

	public function get_account_all() {
		$ret = array();
		$statement = $this->conn->query('SELECT * FROM account WHERE status_ban=0');
		$ret = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $ret;
	}


	/**
	*  Checking username
	*  @param username string
	*  @return true/false (have/don't have)
	*/
	public function hasUsername($username) {
		$statement = $this->conn->prepare('SELECT * FROM account WHERE username=:username' );
		$statement->execute([':username' => $username]); //  set username
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		if (count($result)==1) { //  Have username in Account table
			return true;
		} else { //  Don't have username in Account table
			return false;
		}
	}


	public function hasEmail($email) {
		$statement = $this->conn->prepare('SELECT * FROM account WHERE email=:email' );
		$statement->execute([':email' => $email]); //  set username
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		if (count($result)==1) { //  Have username in Account table
			return true;
		} else { //  Don't have username in Account table
			return false;
		}
	}


	/**
	*  Getting password
	*  @param username string
	*  @return password/null (have/don't have)
	*/
	public function getPassword($username) {
		$statement = $this->conn->prepare('SELECT * FROM Account WHERE username=:username' );
		$statement->execute([':username' => $username]); //  set username
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); //  fetch all to Array in Array
		if (count($result)==1) { //  Have username in Account table
			return $result[0]['password']; //  return password
		} else { //  Don't have username in Account table
			return null;
		}
	}


	/**
	*  Encode password
	*  Password is A-Z, a-z, 0-9 only
	*  ASCII - 20
	*  @param password string
	*  @return encoded string
	*/
	public function encodePassword($password) {
		$newPassword = "";
		$chars = str_split($password); //  split character
		foreach ($chars as $char) {
			$ascii = ord($char); //  convert String to ASCII
			$ascii -= 20; //  left shift ascii
			$newPassword .= chr($ascii);
		}
		return $newPassword;
	}


	/**
	*  Decode password
	*  Password is A-Z, a-z, 0-9 only
	*  ASCII + 20
	*  @param password (left shift) string
	*  @return decoded string
	*/
	private function decodePassword($password) {
		$newPassword = "";
		$chars = str_split($password); //  split character
		foreach ($chars as $char) {
			$ascii = ord($char); //  convert String to ASCII
			$ascii += 20; //  right shift ascii
			$newPassword .= chr($ascii);
		}
		return $newPassword;
	}
}


	/********************************************************************************/
			/* TEST */
	/********************************************************************************/

// $db = new Database();
// $db->openDatabase();
// echo "COnnect";
// echo "<pre>";
// print_r($db->get_event_sort_desc_all());
// echo "</pre>";
// $db->delete_topiccomment_notopic(1);
// echo "Opened Database.<br />";

// $db->create_account('suphawich', '123456', 'Mark', 'organizer', 'Suphawich', 'Sungkhavorn', 'm', 21, 'suphawich.s@ku....', './images/avatar...', '2018-03-08 23:0...');
// $db->create_assessment(1, 4);
// // print_r($db->gene_noquestion(1));
// // $db->confirm_eventmember(1,"hello123");
// // print_r($db->gene_nocomment_notopic(1));
// // print_r($db->gene_notopic_noevent(1));
// // $db->create_comment(1,2,"supanut","ความเห็นที่2",0);
// // $db->create_topic(2,1,"supanut","ทดสอบการตั้งกระทู้","ทดสอบเฉยๆ",0);
// $db->create_event("supanut","ทดสอบ","event",10,20,5000,"","","ทดสอบ",0,0,0,"ไม่มี","ไม่มี",0);

// $db->closeDatabase();
// echo "Closed";
// echo "Closed Database.<br />";
// // echo $db->encodePassword("hello123");
// // $db->decodePassword("4QXX[");
// // $db->hasUsername('admn');
// // $db->getPassword('admi');
?>
</body>
</html>
