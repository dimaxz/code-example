<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1694771164.
 * Generated on 2023-09-15 09:46:04 by www-data 
 */
class PropelMigration_1694771164 
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
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
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `sights`

  DROP PRIMARY KEY,

  ADD `city_id` INTEGER NOT NULL AFTER `remoteness`,

  ADD PRIMARY KEY (`id`,`city_id`);

CREATE INDEX `sights_fi_8d1ded` ON `sights` (`city_id`);

ALTER TABLE `sights` ADD CONSTRAINT `sights_fk_8d1ded`
    FOREIGN KEY (`city_id`)
    REFERENCES `cities` (`id`);

CREATE TABLE `travelers_cities`
(
    `traveler_id` INTEGER NOT NULL,
    `city_id` INTEGER NOT NULL,
    PRIMARY KEY (`traveler_id`,`city_id`),
    INDEX `travelers_cities_fi_8d1ded` (`city_id`),
    CONSTRAINT `travelers_cities_fk_065881`
        FOREIGN KEY (`traveler_id`)
        REFERENCES `travelers` (`id`),
    CONSTRAINT `travelers_cities_fk_8d1ded`
        FOREIGN KEY (`city_id`)
        REFERENCES `cities` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return array(
            'default' => $connection_default,
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
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `travelers_cities`;

ALTER TABLE `sights` DROP FOREIGN KEY `sights_fk_8d1ded`;

DROP INDEX `sights_fi_8d1ded` ON `sights`;

ALTER TABLE `sights`

  DROP PRIMARY KEY,

  DROP `city_id`,

  ADD PRIMARY KEY (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return array(
            'default' => $connection_default,
        );
    }

}