<?php

class m180405_110902_rename_POH_to_POS extends CDbMigration
{
	public function up()
	{
	    $this->execute("UPDATE element_type SET `name` = 'Past Surgery' WHERE `class_name` = 'OEModule\\\\OphCiExamination\\\\models\\\\PastSurgery'");
	}

	public function down()
	{
        $this->execute("UPDATE element_type SET `name` = 'Previous Ophthalmic History' WHERE `class_name` = 'OEModule\\\\OphCiExamination\\\\models\\\\PastSurgery'");
	}

}
