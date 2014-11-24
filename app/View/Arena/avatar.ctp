<?php

	echo $this->Form->create('UploadPicture',array('type'=>'file','class'=>'form-group'));
	echo $this->Form->file('avatar');
	echo $this->Form->end('Upload');
?>
