<?php
require_once("head.php");
header('Content-Type: text/html; charset=utf-8');
require_once "emoji.php";
if(isset($_GET['id'])&&is_numeric($_GET['id'])&&is_numeric($_GET['start'])){
    if(isset($_GET['session_id'])){
        session_id($_GET['session_id']);
    }
    session_start();
    include_once "connect.php";
    $sql;
    $login = isset($_SESSION['user_id']);

    //startnum is number of posts after where the search starts
    $startnum = mysqli_real_escape_string($con,$_GET['start']);
    $limit = 10;
    $u_id = false;

    if($login){
        $u_id = $_SESSION['user_id'];
        $u_stack = $_SESSION['stack_id'];
    }

    //formula for ranking posts by vote/time
   // $formula = "ORDER BY log10(POW(upstacks,2.625) - POW(downstacks,0.5))/POW(log10(POW(ABS(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP( created ) + 1),2))/43200,2)";
    //$formula = "ORDER BY LOG( 5 , ABS( upstacks - downstacks ) + 1) - EXP((UNIX_TIMESTAMP( NOW() ) - UNIX_TIMESTAMP( created )) / 72000)";
    $formula = "ORDER BY UNIX_TIMESTAMP( created )";
    if(isset($_GET['status'])){
        if($_GET['status']=="1"){
            $formula = "ORDER BY UNIX_TIMESTAMP( created )";
        }else if($_GET['status']=="2"){
//            AND ((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP( created )) < 604800) 
            $formula = "ORDER BY ABS(upstacks - downstacks)";
        }
    }

    //expression for NSFW depending on setting
    $nsfw = "AND x.nsfw = 0 ";
    if($login&&isset($_SESSION['nsfw'])&&($_SESSION["nsfw"]!=0)){
        $nsfw = "";
    }

    //different SQL queries depending on the type of stack that is requested
    if($_GET['id']==0){
        //GETID 0 is for topstack
        if($login){
            //retrieving topstack from followed stacks if logged in
            $sql = "SELECT DISTINCT x.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
                    FROM posts x
                      INNER JOIN users y ON x.user_id = y.user_id
                      INNER JOIN stacks s ON s.stack_id = x.stack_id
                      INNER JOIN follow f ON (f.stack_id = x.stack_id OR f.stack_id = x.poster_id)
                    WHERE f.user_id = '$u_id' AND f.following = 1 AND NOT (x.stack_id = 4917) AND visible = 1 AND (x.private = 0 OR (x.private = 1 AND ( x.user_id = '$u_id' OR x.stack_id = '$u_stack'))) $nsfw
                    $formula DESC
                    LIMIT $startnum, $limit";
        }else{
            //retrieving from the list of default stacks for topstack if not logged in
            $sql = "SELECT x.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
                    FROM posts x
                      INNER JOIN users y ON x.user_id = y.user_id
                      INNER JOIN stacks s ON s.stack_id = x.stack_id
                    WHERE x.stack_id IN (6,14, 54, 959,15,16,17,19,20,21,42, 74, 516, 803, 1786, 897, 599, 651, 55, 599, 1529, 1842) AND visible = 1 $nsfw
                    $formula DESC
                    LIMIT $startnum, $limit";
        }
    }else if($_GET['id']=="-1"){
        //gets allstack, ranks things by $formula for all the stacks
        $sql = "SELECT x.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
        FROM posts x
          INNER JOIN users y ON x.user_id = y.user_id
          INNER JOIN stacks s ON s.stack_id = x.stack_id
        WHERE s.is_user = 0 AND visible = 1 $nsfw
        $formula DESC
        LIMIT $startnum, $limit";
    }else if($_GET['id']=="-2"&&$login){
        //this is userstack, and gets info from all the followed users, only available to logged in people
        $sql = "SELECT x.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
        FROM posts x
          INNER JOIN users y ON x.user_id = y.user_id
          INNER JOIN stacks s ON s.stack_id = x.stack_id
          INNER JOIN follow f ON f.stack_id = x.stack_id
        WHERE f.user_id = '$u_id' AND f.following = 1 AND visible = 1 AND s.is_user = 1 AND (x.private = 0 OR (x.private = 1 AND ( x.user_id = '$u_id' OR x.stack_id = '$u_stack'))) $nsfw
        $formula DESC
        LIMIT $startnum, $limit";
    }else if($_GET['id']==-3){
        //newstack, takes all stacks and disregards formula and only takes time as a factor
        $sql = "SELECT x.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
        FROM posts x
          INNER JOIN users y ON x.user_id = y.user_id
          INNER JOIN stacks s ON s.stack_id = x.stack_id
        WHERE s.is_user = 0 AND visible = 1 AND NOT (x.stack_id = 4917) $nsfw
        ORDER BY
            UNIX_TIMESTAMP( created ) DESC
        LIMIT $startnum, $limit";
    }else if($_GET['id']==4917){
        $radius = 5.0;
        if(isset($_GET["distance"])&&is_numeric($_GET["distance"])&&$_GET["distance"]<100.0){
            $radius = mysqli_real_escape_string($con, $_GET["distance"]);
        }
        //geostack
        if(isset($_GET["latitude"])&&isset($_GET["longitude"])){
            $latitude = mysqli_real_escape_string($con,$_GET["latitude"]);
            $longitude = mysqli_real_escape_string($con,$_GET["longitude"]);
            $sql = "SELECT d.*,
                   y.username,y.flair,
                   s.stackname,s.stackflair
                    FROM (
                      SELECT x.*,
                      p.radius,
                      p.distance_unit
                         * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                         * COS(RADIANS(x.latitude))
                         * COS(RADIANS(p.longpoint - x.longitude))
                         + SIN(RADIANS(p.latpoint))
                         * SIN(RADIANS(x.latitude)))) AS distance
                      FROM posts AS x
                      JOIN(
                        SELECT  $latitude  AS latpoint,  $longitude AS longpoint,
                                    $radius AS radius, 111.045 AS distance_unit
                      ) AS p ON 1=1
                      WHERE x.latitude IS NOT NULL AND x.longitude IS NOT NULL AND x.visible = 1 AND x.private = 0 $nsfw
                      AND x.latitude
                        BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                            AND p.latpoint  + (p.radius / p.distance_unit)
                      AND x.longitude
                        BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                            AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                    ) AS d
                      INNER JOIN users y ON d.user_id = y.user_id
                      INNER JOIN stacks s ON s.stack_id = d.stack_id
                    WHERE distance <= radius AND s.is_user=0
                    $formula DESC
                    LIMIT $startnum, $limit";
        }else{
            die ("20");
        }
    }else{
        $stack = mysqli_real_escape_string($con, $_GET['id']);
        $getstacks = mysqli_query($con, "SELECT nsfw FROM stacks WHERE stack_id = '".$stack."' LIMIT 1") or die("2");
        while($row = mysqli_fetch_assoc($getstacks)){
            if($row["nsfw"]==1){
                $nsfw = "";
            }
        }
        if(isset($_GET["distance"])&&is_numeric($_GET["distance"])&&$_GET["distance"]<100.0){
            $radius = mysqli_real_escape_string($con, abs($_GET["distance"]));
            //geostack
            if(isset($_GET["latitude"])&&isset($_GET["longitude"])){
                $latitude = mysqli_real_escape_string($con,$_GET["latitude"]);
                $longitude = mysqli_real_escape_string($con,$_GET["longitude"]);
                $sql = "SELECT d.*,
                   y.username,y.flair
                    FROM (
                      SELECT x.*,
                      p.radius,
                      p.distance_unit
                         * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                         * COS(RADIANS(x.latitude))
                         * COS(RADIANS(p.longpoint - x.longitude))
                         + SIN(RADIANS(p.latpoint))
                         * SIN(RADIANS(x.latitude)))) AS distance
                      FROM posts AS x
                      JOIN(
                        SELECT  $latitude  AS latpoint,  $longitude AS longpoint,
                                    $radius AS radius, 111.045 AS distance_unit
                      ) AS p ON 1=1
                      WHERE x.latitude IS NOT NULL AND x.longitude IS NOT NULL AND x.visible = 1 AND x.private = 0 AND x.stack_id = '".$stack."' $nsfw
                      AND x.latitude
                        BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                            AND p.latpoint  + (p.radius / p.distance_unit)
                      AND x.longitude
                        BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                            AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                    ) AS d
                      INNER JOIN users y ON d.user_id = y.user_id
                    WHERE distance <= radius
                    $formula DESC
                    LIMIT $startnum, $limit";
            }
        }else{
            $userquery = mysqli_query($con, "SELECT is_user FROM stacks WHERE stack_id = $stack");
            while($row = mysqli_fetch_assoc($userquery)){
                $isuser = $row["is_user"];
            }
            if($login){
                //stack specific search, doesn't account for getting the stack info since you are already on the stack
                $conditions = "visible = 1 AND (x.private = 0 OR (x.private = 1 AND ( x.user_id = '$u_id' OR x.stack_id = '$u_stack')))";
            }else{
                $conditions = "visible = 1 AND x.private = 0";
            }
            if($isuser == 1){
                $formula = "ORDER BY UNIX_TIMESTAMP( created )";
                $userconditions="((x.poster_id = $stack AND NOT (x.stack_id = 4917)) OR (x.stack_id = $stack))";
                if(isset($_GET["status"])){
                    if($_GET["status"]==2){
                        $userconditions = "x.poster_id = $stack AND NOT (x.stack_id = 4917)";
                    }elseif($_GET["status"]==1){
                        $userconditions = "x.stack_id = $stack";
                    }
                }
                $sql = "SELECT DISTINCT x.*,
                   y.username, y.flair,
                   s.stackname,s.stackflair
                    FROM posts x
                      INNER JOIN users y ON x.user_id = y.user_id
                      INNER JOIN stacks s ON s.stack_id = x.stack_id
                    WHERE $userconditions AND $conditions $nsfw
                    $formula DESC
                    LIMIT $startnum, $limit";
            }else{
                $userconditions="x.stack_id = $stack";
                $sql = "SELECT x.*,
                   y.username, y.flair
                    FROM posts x
                      INNER JOIN users y ON x.user_id = y.user_id
                    WHERE $userconditions AND $conditions $nsfw
                    $formula DESC
                    LIMIT $startnum, $limit";
            }
        }
    }
//    echo $sql;

    //throws an exception if the query doesnt work
    $result = mysqli_query($con, $sql);
    if($result === false){
        echo '{error: problem}';
        //throw new Exception(mysqli_error($sql));
    }

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    include_once 'humantime.php';

    //if there are no search results based on parameters
    if(!isset($data)){
        die("null");
    }

    //parses the posts to check if you've voted and adds in additional fields
    for($x = 0; $x < sizeof($data); $x++){
        if($login){
            $sql = "SELECT *
        FROM votes
        WHERE user_id = '".$_SESSION['user_id']."' AND
        post_id = '".$data[$x]['post_id']."'";
            $res = mysqli_query($con, $sql) or die('error');
            if(mysqli_num_rows($res)==0){
                $data[$x]['vote'] = 1;
            }else{
                while($row = mysqli_fetch_assoc($res)){
                    $data[$x]['vote'] = $row['vote_type'];
                }
            }
            if($data[$x]['user_id']==$_SESSION['user_id']||$_SESSION['admin']||$data[$x]['stack_id']==$_SESSION['stack_id']){
                $data[$x]['delete'] = 1;
            }else{
                $data[$x]['delete'] = 0;
            }
            $data[$x]['report'] = 1;
        }else{
            $data[$x]['vote'] = 1;
            $data[$x]['delete'] = 0;
        }
        //turns the time posted into a human readable time because on time ago.
        $data[$x]['created'] = humanTiming(strtotime($data[$x]['created']));
        $data[$x]['text'];
    }
    echo json_encode($data);
}
function convert_accent($string)
{
    return htmlentities($string, ENT_COMPAT, 'UTF-8');
}
