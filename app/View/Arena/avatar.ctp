<?php

	echo $this->Form->create('UploadPicture',array('type'=>'file'));
	echo $this->Form->file('avatar');
	echo $this->Form->end('Upload');
?>
