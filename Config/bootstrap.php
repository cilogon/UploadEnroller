<?php

Configure::write('UploadEnroller.directory', '/srv/comanage-registry/local/uploads');

App::uses('CakeEventManager', 'Event');
App::uses('UploadEnrollerListener', 'UploadEnroller.Lib');
CakeEventManager::instance()->attach(new UploadEnrollerListener());
