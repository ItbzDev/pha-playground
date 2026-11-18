<updates>

    <update version="1">

        <command target="main">

            CREATE TABLE _phorza_demo_update_table (
                id      INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name    VARCHAR(255) NOT NULL
            ) ENGINE MyISAM;

        </command>

        <command target="main">

            INSERT INTO _phorza_demo_update_table (id, name)
            VALUES (default, 'demo_update_data');
            
        </command>

    </update>

</updates>