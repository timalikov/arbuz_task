<?php
    $cn = pg_connect("host=localhost port=5432 dbname=arbuz user=postgres password=1234");
    
    $result = pg_query($cn, "select * from customers");
    while($row = pg_fetch_object($result))
    {
        echo "\n".$row->name;
    }
    pg_close($cn);
?>