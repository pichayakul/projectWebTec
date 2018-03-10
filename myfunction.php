<?php
include "database/epmtfafn_satta_db.php" ;
  if (isset($_POST["update"])){
    $user = $_POST["username"];
    $tic = $_POST["tickets"];
    $req = $_POST["request_date_time"];
    $joi = $_POST["join_date_time"];
    $pay = $_POST["payment_path"];
    $pre = $_POST["pre_path"];
    $noevent=$_POST["noevent"];
    $status=$_POST["status"];
  
  $db = new Database();
  $db->openDatabase();
  if ($status=="accepted"){
  $db->confirm_eventmember($noevent,$user);
  }
  else{
    $db->decline_eventmember($noevent,$user);
    
  }
                  
                  $requestRow = $db->get_eventmember_all($noevent);
                    $cont='';
                  for ($round=0;$round < count($requestRow);$round++){
                            if ($requestRow[$round]["status"]=='accepted'){
                                $cont.='<tr class="success">';
                            }
                            else{
                                $cont.='<tr class="warning">';
                            }

                            $cont.='<td>'.$requestRow[$round]["username"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["tickets"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["request_date_time"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["join_date_time"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["payment_path"].'</td>';
                            $cont.='<td>'.$requestRow[$round]["pre_path"].'</td>';
                             $dataRequest="'".$requestRow[$round]["username"]."',";
                            $dataRequest.="'".$requestRow[$round]["tickets"]."',";
                            $ticke = $requestRow[$round]["tickets"];
                            $dataRequest.="'".$requestRow[$round]["request_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["join_date_time"]."',";
                            $dataRequest.="'".$requestRow[$round]["payment_path"]."',";
                            $dataRequest.="'".$requestRow[$round]["pre_path"]."',";
                            $dataRequest.="'".$noevent."'";
                            if ($requestRow[$round]["status"]=='accepted'){
                              $cont.='<td>accepted</td>';
                            }
                            else{
                              $cont.='<td><button type="button" class="btn btn-success" onclick="acceptRequest('.$dataRequest.')" >accept</button>
                              <button type="button" class="btn btn-danger" onclick="declineRequest('.$dataRequest.')" >decline</button>
                              </td>';
                              
                                
                            }
                            $cont.='</tr>';
                          }
                          
                // console.log(data);
                echo '||splitIT||'.$cont.'||splitIT||';
                $ticke;
                $db-> 
  $db->closeDatabase();
  

  }
?>
