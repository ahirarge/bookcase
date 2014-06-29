# Bookcase

Bookcase is a PHP 5.3+ simple media library system for Laravel 4.

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require-dev": {
		"ahir/bookcase": "dev-master"
	}
}
```

After installing the package, open your Laravel config file app/config/app.php and add the following lines.

In the $providers array add the following service provider for this package.

```php
'Ahir\Bookcase\BookcaseServiceProvider',
'Ahir\Pathman\PathmanServiceProvider',
```

Add the `Bookcase` and  `Pathman` facades to the `aliases` array in `app/config/app.php`:

```php
'aliases' => array(
		'Bookcase' => 'Ahir\Bookcase\Facades\Bookcase',
		'Pathman' => 'Ahir\Pathman\Facades\Pathman',
	),
```

### Configuration

* `input`: File input name of the form.

* `libraryPath` (public/library/): Upload path.

* `maxSize` (5242880): Maximum file size. (Byte)

* `maxWidth` (3000): Maximum image width.

* `maxHeight` (3000): Maximum image height.


### Usage

If uploaded file is not a image file then file is compressed with ZIP. 

```php	
try {
	// Trying upload
	$result = Bookcase::upload(array(
			'input' => 'file'
		));
	// Showing results
	echo $result->type;
	echo $result->size;
	echo $result->path;
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}		
```

### Dependencies

* `ahir/pathman`
