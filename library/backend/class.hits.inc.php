<?php
namespace backend;


    /*
    # Sample table
    CREATE TABLE `hits_vendors` (
        `vendor_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Foreign Key',
        `hits` int(10) unsigned NOT NULL COMMENT 'Hits Counter',
        PRIMARY KEY (`vendor_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    Usage example:
        $hits = new hits();
        $hits->update_hits('vendors', 'vendor_id', 1);

    */

/**
 * Updates hits of some entities
 */
class hits
    extends \common\mysql
{
    public function update_hits($table_name = "", $pk_name = "", $pk_id = 0)
    {
        # choose a table.
        # insert into ....
        # on duplicate key
        # update hits =hits + 1 where ...

        # validate table name
        $table_name = $this->sanitze($table_name);
        $pk_name = $this->sanitze($pk_name);
        $pk_id = (int)$pk_id;

        $update_sql = "
# Update HITs counter
INSERT INTO `hits_{$table_name}` (
	`{$pk_name}`, `hits`
) VALUES (
	{$pk_id}, 1
) ON DUPLICATE KEY UPDATE
	`hits` = `hits` + 1
;";

        return $this->query($update_sql);
    }

    /**
     * Clean up the table name for preventing form SQL hacks
     */
    private function sanitze($name = "")
    {
        $name = preg_replace('/[^a-z\_]/', "", $name);

        return $name;
    }

    public function reset_hits($table_name = "", $pk_name = "", $pk_id = 0)
    {
        $table_name = $this->sanitze($table_name);
        $pk_name = $this->sanitze($pk_name);
        $pk_id = (int)$pk_id;

        $reset_sql = "UPDATE `hits_{$table_name}` SET `hits`=0 WHERE `{$pk_name}`={$pk_id};";

        return $this->query($reset_sql);
    }
}

