<?php

/**
* Loads a simple PSR-4 autoloader for the Validator.
*/
spl_autoload_register(function(string $className){
	//A mapping of namespace prefixes to base directories.
	$prefixes = [
		'Validator' => 'src\\Validator',
	];

	//Get list of namespaces, and unqualified class name
	$namespaces = explode('\\', $className);
	$class = array_pop($namespaces);

	//Find the longest prefix to use as the base path
	$basePath = "";
	$pathParts = [];
	while(count($namespaces))
	{
		$prefixStr = implode('\\', $namespaces);
		if(isset($prefixes[$prefixStr]))
		{
			$basePath = $prefixes[$prefixStr];
			break;
		}

		else
		{
			array_unshift($pathParts, array_pop($namespaces));
		}
	}

	//Found
	if($basePath != "")
	{
		array_unshift($pathParts, $basePath);
		array_push($pathParts, $class . '.php');
		$file = implode(DIRECTORY_SEPARATOR, $pathParts);
		if(file_exists($file))
		{
			require $file;
		}
	}
});

?>