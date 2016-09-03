<?php

require_once( __DIR__ . '/lib/html_table.class.php' );

$opts = getopt( '', ['format:'] );
$format = @$opts['format'];

$files = rglob( __DIR__ . '/apidoc.php' );
sort( $files );

$apis = [];
$apigroups = [];
foreach( $files as $docfile ) {
    require_once( $docfile );
    $apiname = basename( dirname( $docfile ) );
    $classname = 'api_' . $apiname;
    
    $obj = new $classname;
    $apis[$apiname] = $obj;
    
    list($group) = explode( '_', $apiname, 2 );
    $apigroups[$group]['apis'][$apiname] = $obj;
    $apigroups[$group]['notes'] = null;
}

$table = new html_table();
$table->table_attrs = array( 'class' => 'bordered' );

$apiversion = file_get_contents( __DIR__ . '/VERSION' );

$dates = ['created' => '2016-08-19',
          'updated' => '2016-09-03'
         ];

$authors = [ 'Dan Libby <dan@osc.co.cr>',
             'Mike Rosseel <mike.rosseel@gmail.com>',
             'Manfred Karrer <manfred@bitsquare.io>',
           ];

function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}

function e($buf) {
    return htmlentities( $buf );
}

// em: escape markdown. for now, a no-op.
function em($buf) {
    $map = ['|' => '\|',
            '[' => '\[',
            ']' => '\]',
            '(' => '\(',
            ')' => '\)',
            '`' => '\`',
            ];
    return strtr( $buf, ['|' => '\|'] );
}


$doctitle = 'Bitsquare API Specification';
$intro = [
    'Intro' => <<< END
The API is part of the Bitsquare application and may be accessed by making
REST requests directly to bitsquare running on localhost.

REST was chosen over pure json-rpc because it simplifies development and
debugging of client apps when developers can easily try out APIs directly in a
web browser or via curl.

Authentication is performed via HTTP Basic Auth.  An RPC username and password
must be configured or the RPC service will not be available. By default, access
is only allowed via localhost. This API is intended for use in trusted
environments only.  This closely mirrors the security model of the bitcoin-core
RPC API.
END

];
foreach( $intro as &$text ) {
    $text = explode( "\n\n", $text );
}


$errorinfo = [
    
    'summary' => 'APIs will return an error struct on any error.  The error struct looks like:',
    'example' => <<< END
{
    "error": true,
    "code: 100,
    "message": <string>
}
END
,
    'body' => <<< END
Results from successful API calls will not contain the "error" key, or if present the value will be false.

Therefore, an error can be detected by checking that the error key exists and is set to true.
END
];


?>

<?php if( $format == 'markdown' ): ?>
# <?= em($doctitle) ?>

```
Version: <?= em($apiversion) ?>
Authors: <?= em(implode( ', ', $authors )) ?> 
Created: <?= em($dates['created']) ?> 
Last Updated: <?= em($dates['created']) ?> 
```

<?php foreach( $intro as $header => $text ): ?>
## <?= em($header) ?>

<?php foreach( $text as $para ): ?>
<?= em($para) ?>


<?php endforeach ?>
<?php endforeach ?>

## API List

<?php foreach( $apigroups as $groupname => $group ): ?>
* <?= ucfirst($groupname) ?>

<?php foreach( $group['apis'] as $method => $api ): ?>
  * [/api/<?= em($method) ?>](#user-content-api<?= em($method) ?>)
<?php endforeach ?>
<?php endforeach ?>
    
Error responses are documented [at bottom](#user-content-error-responses).
    
<?php foreach( $apis as $method => $api ): ?>

## /api/<?= em($method) ?>


<?= em($api->get_description()) ?>

<?php foreach($api->get_examples() as $example): ?>

### Sample Request

    http://localhost/api<?= em($example['request']) ?>


### Sample Response
```json
<?= em($example['response']) ?>

```

<?php endforeach ?>
    
### Parameters

<?php if( @count( $api->get_params() ) ): ?>

<?php foreach($api->get_params() as $idx => $row): ?>
<?php if( $idx == 0 ): ?>
<?= implode( '|', array_map( function($v) { return em($v); }, array_keys($row)) ); ?>

<?= implode( '|', array_map( function($v) { return str_pad( '-', strlen($v), '-'); }, array_keys($row)) ); ?>

<?php endif ?>
<?= implode( '|', array_map( function($v) { return em($v); }, $row) ); ?>

<?php endforeach ?>

<?php else: ?>
None
<?php endif ?>

    
<?php if( count($api->get_notes()) ): ?>
### Notes
<?php foreach($api->get_notes() as $note): ?>
* <?= em($note) ?>

<?php endforeach ?>
<?php endif ?>
    
<?php if( count($api->get_seealso()) ): ?>
### See Also

<?php foreach($api->get_seealso() as $seealso): ?>
* [<?= $seealso ?>](#user-content-api<?= $seealso ?>)
<?php endforeach ?>
<?php endif ?>
    
<?php endforeach ?>

## Error Responses

<?= em($errorinfo['summary']) ?>

```json
<?= em($errorinfo['example']) ?>

```

<?= em($errorinfo['body']) ?>
<?php else: ?>
<html>
<head>
  <title><?= e($doctitle) ?></title>
  <link href="https://market.bitsquare.io/css/bitsquare/style.css" media="screen" rel="stylesheet" type="text/css">
  <link href="https://market.bitsquare.io/css/bitsquare/css.css" id="opensans-css" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://market.bitsquare.io/css/styles.css" type="text/css">
  <link href="https://market.bitsquare.io/favicon.ico" rel="icon" type="image/x-icon">
        
<style>
h1, h2, h3, h4, h5, h6 {
    margin-top: 12px;
    margin-bottom: 10px;
}
#apiversion {
    position: absolute;
    right: 10px;
    top: 5px;
}
div.api, div.toc, div.errors, div.intro {
    width: 80%;
    margin-top: 20px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
}
div.method {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}
div.description {
    margin-left: 25px;
}
div.requestexample {
    margin-left: 25px;
    margin-right: 25px;
    border: grey dashed 1px;
    background-color: white;
    padding: 10px;
}
div.responseexample {
    margin-left: 25px;
    margin-right: 25px;
    white-space: pre;
    margin-bottom: 10px;
    border: grey dashed 1px;
    background-color: white;
    padding: 10px;
}
div.params div {
    margin-left: 25px;
    margin-right: 25px;
    margin-bottom: 20px;
}
div.toc div.apigroup {
    margin-left: 15px;
}
div.toc ul {
    margin: 0px;
    list-style-type: square;
}
div.toc h5 {
    margin: 0px;
}
div.errors {
    white-space: pre-wrap;
}
div.intro td {
    padding: 0px;
    padding-right: 10px;
}

</style>
</head>
<body>

<div class="intro widget">
<h2><?= e($doctitle) ?></h2>
<p id="apiversion">Version: <?= e($apiversion) ?></p>
<table cellspacing="0">
<tr><td>Authors:</td><td><?= e(implode( ', ', $authors )) ?><br/></td></tr>
<tr><td>Created:</td><td><?= e($dates['created']) ?><br/></td></tr>
<tr><td>Last Updated:</td><td><?= e($dates['created']) ?></td></tr>
</table>

<?php foreach( $intro as $header => $text ): ?>
<h4><?= e($header) ?></h4>
<?php foreach( $text as $para ): ?>
<p><?= e($para) ?></p>

<?php endforeach ?>
<?php endforeach ?>
</div>

<div class="toc widget">
    <h4>Bitsquare APIs:</h4>
<?php foreach( $apigroups as $groupname => $group ): ?>
    <div class="apigroup">
    <h5><?= e(ucfirst($groupname)) ?></h5>
    <ul>
<?php foreach( $group['apis'] as $method => $api ): ?>
        <li><a href="#<?= e($method) ?>"><?= e($method) ?></a></li>
<?php endforeach ?>
    </ul>
    </div>
<?php endforeach ?>
    
    Error responses are documented <a href="#errors">here</a>.
    
</div>


<?php foreach( $apis as $method => $api ): ?>
<div class="api widget">
    <div class="method" id="<?= e($method) ?>">/api/<?= e($method) ?></div>
    <div class="description"><?= e($api->get_description()) ?></div>
    <div class="examples">
        <?php foreach($api->get_examples() as $example): ?>
        <div class="example">
            <h4>Sample Request</h4>
            <div class="requestexample">http://localhost/api<?= e($example['request']) ?></div>
            <h4>Sample Response</h4>
            <div class="responseexample"><?= e($example['response']) ?></div>
        </div>
        <?php endforeach ?>
    </div>
    
    <div class="params">
        <h4>Parameters</h4>
        <div>
        <?php if( @count( $api->get_params() ) ): ?>
        <?= $table->table_with_header($api->get_params()) ?>
        <?php else: ?>
        None
        <?php endif ?>
        </div>
    </div>
    
    <?php if( count($api->get_notes()) ): ?>
    <div class="notes">
        <h4>Notes</h4>
        <ul>
        <?php foreach($api->get_notes() as $note): ?>
        <li class="noteitem"><?= e($note) ?></li>
        <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
    
    <?php if( count($api->get_seealso()) ): ?>
    <div class="seealso">
        <h4>See Also</h4>
        <ul>
        <?php foreach($api->get_seealso() as $seealso): ?>
        <li class="seealsoitem"><a href="#<?= e($seealso) ?>"><?= e($seealso) ?></a></li>
        <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
    
</div>
<?php endforeach ?>

<div class="errors widget" id="errors">
    <h4>Error Responses</h4><?= e($errorinfo['summary']) ?>


<div class="responseexample">
<?= e($errorinfo['example']) ?>
</div>
<?= e($errorinfo['body']) ?>   
    
</div>

</body>
</html>
<?php endif ?>