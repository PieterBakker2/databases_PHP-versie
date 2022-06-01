<?php
include('../scripts/dbManagement.php');
?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <title>Dynamische Websites met Databases!</title>
    </head>
    <body class="container">
        <main class="mx-5 p-5">
            <div class="text-center">
                <h1 class="fw-bold">Databases Module</h1>
                <p class="lead">Maak een dynamische website met een database.</p>
            </div>

            <div class="row mx-5 p-5">
                <div class="col">
                <h3>lesmateriaal</h3>
                    <a class="btn btn-success" href="/PHPlessen" title="phpLessen" target="_blank">opdrachten en voorbeelden</a>
                    <a class="btn btn-danger" href="/PHPlessen/PDF/Module_PHP_2020.pdf" title="phpLessen" target="_blank">PDF met vragen</a>
                    <p>Je maakt de opdrachten in GitPod (VS-code) en bekijkt daar de broncode. Je bekijkt de uitvoer via bovenstaande knop.</p>
                <h3>Demo-website</h3>
                    <a class="btn btn-info" href="/demoSite" title="demo" target="_blank">Foto Bloch</a>
                    <a class="btn btn-outline-info" href="/demoSite/html" title="demo" target="_blank">HTML-versie</a>
                    <p>Bekijk hier een uitgewerkt voorbeeld waarin PHP, HTML, CSS en een MySQL-database worden gecombineerd.</p>
                <h3>phpMyAdmin & Querier</h3>
                    <a class="btn btn-outline-primary" href="/phpmyadmin" title="phpMyAdmin" target="_blank">Open phpMyAdmin</a>
                    <p>Login met <strong>root</strong> als gebruikersnaam zonder wachtwoord.</p>
                </div>
                <div class="col">
                    <h3>Database Beheer</h3>
                    <p>Hieronder staat de lijst met databases die op dit moment actief zijn in MySQL:</p>
                    <?php
                    $mysqli = new mysqli("localhost", "root");
                    if ($result = $mysqli->query("SHOW databases")) {
                        $databases = array();
                        while ($row = $result->fetch_row()) {
                            $dbName = $row[0];
                            // Filter out default databases
                            if ($dbName != "information_schema" && $dbName != "performance_schema" && $dbName != "sys" && $dbName != "mysql") {
                                $databases[] = $dbName;
                            }
                        }
                        $result->free_result();
                    }
                    echo "<b>" .count($databases) . " databases: </b>";
                    echo "<ul>";
                    foreach ($databases as $dbName) {
                        echo "<li>".$dbName."</li>";
                    }
                    echo "</ul>";

                    function info($msg)
                    {
                        echo '<div id="result-msg" class="alert alert-success" role="alert">' . $msg . '</div>';
                    }

                    if ($importDone) {
                        info("Databases geïmporteerd.");
                    }
                    if ($exportDone) {
                        info("Databases gëexporteerd.");
                    }
                    if ($restoreDone) {
                        info("Standaard databases hersteld.");
                    }
                    ?>
                    <div id="loading" class="alert alert-info" style="display: none;" role="alert">
                        <div class="d-flex align-items-center">
                            <p id="loading-msg">Aan het laden..</p>
                            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                        </div>
                    </div>
                    <form id="db-man-form" action="index.php" method="post">
                        <div class="vstack gap-2 me-5">
                            <button class="btn btn-primary" name="export" value="1">Exporteer databases</button>
                            <button class="btn btn-outline-primary" name="import" value="1">Importeer databases</button>
                            <button class="btn btn-outline-danger" name="restore_default" value="1">Herstel standaard</button>
                        </div>
                    </form>
                    <script>
                        document.getElementById("db-man-form").addEventListener('submit', () => {
                            document.getElementById("loading").style.display = "";
                            if (document.getElementById("result-msg") != null) {
                                document.getElementById("result-msg").style.display = "none";
                            }
                        });
                    </script>
                </div>

            </div>
        </main>
        <div class="container mt-5">
            <footer class="d-flex flex-wrap align-items-center py-3 my-4 border-top">
                <?php
                echo '<span class="text-muted mx-5">PHP versie: ' . phpversion() . '</span>';
                echo '<span class="text-muted">MySQL versie: ' . $mysqli->server_version . '</span>';
                ?>
            </footer>
        </div>
    </body>
</html>