<?php

require_once(dirname(__FILE__) . '/SSI.php');

function inject_doinject() {
    if (isset($_GET['inline']) || isset($_GET['inject']))
    {
        global $smcFunc;
        if (isset($_GET['inline']))
            $query = $_GET['inline'];
        else 
            $query = "select posts from smf_member where id_member='" . $_GET['inject'] . "'";

        $result = $smcFunc['db_query']('', $query);

        if (!isset($_GET['blind'])) 
        {
            ob_start();
            var_dump($result);
            $raw_result = ob_get_clean();

            echo "
                <h5>Raw</h5>
                $raw_result;
                <p>
                ";

            echo "<h5>Results</h5><p>";

            $headers = false; 
            echo '<table border="1">';
            while ($row = $smcFunc['db_fetch_assoc']($result))
            {
                if (!$headers) {
                    echo "<tr>";
                    foreach ($row as $key => $value) 
                        echo "<td><b>$key</b></td>";
                    echo "</tr>"; 
                    $headers = true;
                }
                echo "<tr>";
                foreach ($row as $value) 
                    echo "<td>$value</td>";
                echo "</tr>"; 
            }
            echo "</table>";
        }
        $smcFunc['db_free_result']($result);
    }
}

?>
