<?php

namespace Jundar;

/**
* A simple PSR-4 compatible Autoloader.
* @todo Verify that this class is indeed PSR-4 compliant.
*/
class Autoloader
{
	/**
	* @var array $prefixes A mapping of namespace prefixes to base directories.
	*/
	protected $prefixes = [];

	/**
	* Adds a prefix.
	* @param string $prefix The namespace prefix
	* @param string $dir The base directory for the prefix
	*/
	public function addPrefix(string $prefix, string $dir)
	{
		$current = $this->prefixes[$prefix] ?? [];
		$this->prefixes[$prefix] = array_merge($current, [$dir]);
	}

	/**
	* Adds an array of prefixes for a single base directory.
	* @param string $prefix
	* @param array $dirs
	*/
	public function addPrefixes(string $prefix, array $dirs)
	{
		foreach($dirs as $dir)
		{
			$this->addPrefix($prefix, $dir);
		}
	}

	/**
	* Determines if a prefix exists
	* @param string $prefix
	* @return bool
	*/
	public function prefixExists(string $prefix): bool
	{
		return isset($this->prefixes[$prefix]);
	}

	/**
	* Registers the autoloader with SPL.
	*/
	public function register()
	{
		spl_autoload_register([$this, 'loadClass']);
	}

	/**
	* Loads a class based on its fully qualified name.
	* @param string $className The name of the class
	*/
	public function loadClass(string $className)
	{
		//Get list of namespaces, and unqualified class name
		$namespaces = explode('\\', $className);
		$class = array_pop($namespaces);

		//Find the longest prefix to use as the base path
		$basePaths = [];
		$pathParts = [];
		while(count($namespaces))
		{
			$prefixStr = implode('\\', $namespaces);
			if(isset($this->prefixes[$prefixStr]))
			{
				$basePaths = $this->prefixes[$prefixStr];
				break;
			}

			else
			{
				array_unshift($pathParts, array_pop($namespaces));
			}
		}

		//Found
		if($basePaths != [])
		{
			foreach($basePaths as $basePath)
			{
				$fileParts = array_merge([$basePath], $pathParts, [$class . '.php']);
				$file = implode(DIRECTORY_SEPARATOR, $fileParts);
				if(file_exists($file))
				{
					require $file;
					break;
				}

				else
				{
					print "Could not find: $file\n";
				}
			}
		}
	}
}

?>