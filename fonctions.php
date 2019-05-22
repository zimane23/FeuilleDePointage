<?php

function dd($var)
{
    echo "<pre>";
    var_dump($var);
    die();
}

function getUserById($id, $db)
{
    try
    {
	    return query("SELECT * FROM users WHERE id = :id LIMIT 1",
				    array("id" => $id),
				    $db)->fetchAll(PDO::FETCH_OBJ)[0];
    }
    catch(Exception $e)
    {
		return false;
	}
}

function query($query, $bindings, $db)
{
	$stmt = $db->prepare($query);
	$stmt->execute($bindings);
	return $stmt;
}

function isValideDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


function isSunday($date)
{
    return (date('N', strtotime($date)) == 7);
}

function prevSunday($date = null)
{
    if (!$date) $date = date('Y-m-d', time());
    if (isSunday($date)) return $date;
    else return date('Y-m-d', strtotime('last Sunday', strtotime($date)));
}

function compareCodes($code1, $code2)
{

    if($code1->code == $code2->code) {
        return 0;
    }
return -1;
}
?>