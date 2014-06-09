<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1402315430.
 * Generated on 2014-06-09 14:03:50 by b3k
 */
class PropelMigration_1402315430
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP INDEX `channel_slug` ON `channel`;

CREATE UNIQUE INDEX `channel_slug` ON `channel` (`slug`(255));

DROP INDEX `subscription_plan_code` ON `subscription_plan`;

DROP INDEX `subscription_plan_slug` ON `subscription_plan`;

CREATE INDEX `subscription_plan_code` ON `subscription_plan` (`subscription_plan_code`(10));

CREATE UNIQUE INDEX `subscription_plan_slug` ON `subscription_plan` (`slug`(255));

DROP INDEX `user_username` ON `user`;

DROP INDEX `user_email` ON `user`;

DROP INDEX `user_username_2` ON `user`;

CREATE INDEX `user_username` ON `user` (`user_username`(32));

CREATE INDEX `user_email` ON `user` (`user_email`(70));

CREATE INDEX `user_username_2` ON `user` (`user_username`(32));

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP INDEX `channel_slug` ON `channel`;

CREATE UNIQUE INDEX `channel_slug` ON `channel` (`slug`);

DROP INDEX `subscription_plan_code` ON `subscription_plan`;

DROP INDEX `subscription_plan_slug` ON `subscription_plan`;

CREATE INDEX `subscription_plan_code` ON `subscription_plan` (`subscription_plan_code`);

CREATE UNIQUE INDEX `subscription_plan_slug` ON `subscription_plan` (`slug`);

DROP INDEX `user_username` ON `user`;

DROP INDEX `user_email` ON `user`;

DROP INDEX `user_username_2` ON `user`;

CREATE INDEX `user_username` ON `user` (`user_username`);

CREATE INDEX `user_email` ON `user` (`user_email`);

CREATE INDEX `user_username_2` ON `user` (`user_username`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}