<?php
include "../_func.php"
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>VLOOKUP</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<body>

<?php
if ($_POST['mode'] == "create") {
    //pre($_POST);
    $sourceIndex = $_POST['sourceIndex'];
    $sourceIndexBaseTable = $_POST['targetIndexBaseTable'];
    $giveTargetIndex = $_POST['givesTargetIndex'];

    #excel source table
    $rows = explode("\n", $_POST['sourceTable']);
    $tmpReturn = array();
    if ($rows) {
        $rowId = 0;
        foreach ($rows as $row) {
            $cell = explode("\t", $row);
            $rowId++;
            $tmpReturn[$rowId] = array_map_recursive("trim",$cell);
        }
    }
    $sourceTable = $tmpReturn;
    #pre($sourceTable);
    if($_POST['isFirstlineHeader']){
        $headerRow = $sourceTable[1];
        $headerRow[] = 'FOUNDEDVAL';
        unset($sourceTable[1]);
    }
    #pre($headerRow);
    #pre($sourceTable);
    #excel target table
    $rows = explode("\n", $_POST['targetTable']);
    //var_dump($rows);exit;
    $tmpReturn = array();
    if ($rows) {
        $rowId = 0;
        foreach ($rows as $row) {
            $cell = explode("\t", $row);
            $rowId++;
            $tmpReturn[$rowId] = array_map_recursive("trim",$cell);
        }
    }
    $targetTable =$tmpReturn;


    foreach($sourceTable as $sourceKey=>$sourceVal){
        $foundRow = array_filter_multi($targetTable,$sourceIndexBaseTable,$sourceVal[$sourceIndex],1);
        $sourceTable[$sourceKey]['NEWCOLUMN'] =  $foundRow[0][$giveTargetIndex];
        $lbl = mt_rand(0,2000);
        #pre($sourceVal,"",$lbl);
        #pre($foundRow,"",$lbl);
        #echo "<hr>";
    }
    #pre($sourceTable);


    echo arrayToTable($sourceTable,$headerRow);

}

?>

<!-- Begin page content -->
<main role="main" class="container">
    <h1 class="mt-5">VLOOKUP</h1>
    <form class="form-horizontal" method="post">
        <input type="hidden" name="mode" value="create"/>
        <fieldset>

            <!-- Form Name -->
            <legend>Form Name</legend>
            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textarea1">Kaynak Tablo: </label>
                <div class="col-md-4">
                    <textarea class="form-control" id="textarea1" name="sourceTable"><?php echo $_POST['sourceTable'] ?></textarea>
                    <span class="help-block">Excelden</span>
                </div>
            </div>
            <!-- Multiple Checkboxes -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="checkboxes"></label>
                <div class="col-md-4">
                    <div class="checkbox">
                        <label for="checkboxes-0">
                            <input type="checkbox" checked name="isFirstlineHeader" id="checkboxes-0" value="1">
                            İlk satır başlık satırı
                        </label>
                    </div>

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput1">Kaynak Index</label>
                <div class="col-md-4">
                    <input id="textinput" name="sourceIndex" type="text" placeholder="placeholder" value="<?php echo $_POST['sourceIndex'] ?>"
                           class="form-control input-md">
                    <span class="help-block">0 dan baslar</span>
                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textarea2">Hedef Tablo: </label>
                <div class="col-md-4">
                    <textarea class="form-control" id="textarea2" name="targetTable"><?php echo $_POST['targetTable'] ?></textarea>
                    <span class="help-block">Excelden</span>
                </div>
            </div>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput4">Hedef Tablo Baz Index</label>
                <div class="col-md-4">
                    <input id="textinput4" name="targetIndexBaseTable" type="text" placeholder="placeholder" value="<?php echo $_POST['targetIndexBaseTable'] ?>"
                           class="form-control input-md">
                    <span class="help-block">Kaynak Index ile eşit</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="textinput1">Getirilecek Hedefteki Index</label>
                <div class="col-md-4">
                    <input id="targetTableIndex" name="givesTargetIndex" type="text" placeholder="placeholder" value="<?php echo $_POST['givesTargetIndex'] ?>"
                           class="form-control input-md">
                    <span class="help-block">0 dan baslar</span>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <button id="singlebutton" type="submit" name="singlebutton" class="btn btn-primary">Gönder</button>
                </div>
            </div>
        </fieldset>
    </form>

</main>

<footer class="footer">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
