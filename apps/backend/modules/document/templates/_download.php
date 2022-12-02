<?php echo link_to('Download', '@document_download?slug='.$document->getId().'|'.Utils::slugify($document->getName()) ); ?>
