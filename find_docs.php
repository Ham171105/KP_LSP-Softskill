<?php

require __DIR__.'/vendor/autoload.php';

// The files might be in the user's Downloads or we don't have the absolute path.
// Wait, the prompt history says: "@[Kepemimpinan - Belakang.doc] ...".
// The system uploaded them to the workspace root or some location. Let's find them first!
