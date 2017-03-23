<div class="holder">
    <?php
    $_GET['q'] = isset($_GET['q']) ? addslashes($_GET['q']) : "";
    if (!$_GET['q']) {
        echo 'No hints';
    } else {
        $sql = "SELECT subdomain_id, subdomain_name FROM query_subdomains WHERE subdomain_name LIKE '%{$_GET['q']}%' LIMIT 10;";
        $db->query($sql);
        $counter = 0;
        while ($db->next_record()) {
            ++$counter;
            echo "<div class='result'>{$counter}. <a href='http://{$db->row_data['subdomain_name']}/backend/backend/public_html/'>Go</a> - <a href='subdomains-details.php?id={$db->row_data['subdomain_id']}'>{$db->row_data['subdomain_name']}</a></div>";
        }

        if (!$counter) {
            echo "<div class='result' style='border:none;'>No matches</div>";
        }
    }
    ?>
</div>