<?php
include_once 'db_connection.php';

// PHP/MYSQL :: lagring av alle variabler brukt på denne siden
$query_getkategorier = $conn->query("SELECT * FROM Kategori");
$kategorier = $query_getkategorier->fetch_all(MYSQLI_ASSOC);


// PHP/MYSQL :: sending av data til DB ved POST
if (!empty($_POST))
  {
    // Bruker prepared statements for å unngå SQL-injection
    $stmt_nybedrift  = $conn->prepare("INSERT INTO Bedrifter VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_nybedrift->bind_param('sssisss', $bedrift_navn, $bedrift_kategori, $bedrift_adresse, $bedrift_tlf, $bedrift_beskrivelse, $bedrift_tider ,$bedrift_nett);

    // Setter variabler
    $bedrift_navn           = $_POST['Navn'];
    $bedrift_kategori       = $_POST['Kategori_navn'];
    $bedrift_adresse        = $_POST['Adresse'];
    $bedrift_tlf            = $_POST['Telefon'];
    $bedrift_beskrivelse    = $_POST['Beskrivelse'];
    $bedrift_tider          = $_POST['Åpningstider'];
    $bedrift_nett           = $_POST['Nettside'];

    // Kjører spørring
    $stmt_nybedrift->execute();
    $stmt_nybedrift->close();
  }

// MySQL :: koble fra DB
$conn->close();

//
// Google Maps API -> AIzaSyD2gW_BNLEQWE6CUd48__dvjLDk0Bc7kCs
// Google Maps API2-> AIzaSyDywUZI16jpELxuAZ6VFnNtaGyElz
//
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Legg til bedrift</title>

<!-- Midlertidig link til TwitterBootstrap - byttes ut med egen CSS etterhvert -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

   <div class="container">

      <div class="jumbotron">
        <h1>Legg til ny bedrift i databasen</h1>
        <p class="lead">Her kan man legge til ny bedrift i DB.</p>
      </div>
       
      <div class="row">
        <div class="col-lg-5">
            <h4>Informasjon - Ny bedrift</h4>
            <div class="input-group" style="width: 90%">
                    <form method="POST" name="formNyBedrift" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                        Bedriftens navn: <input type="" class="form-control" name="Navn" id="Navn" /><br>
                        Adresse: <input type="text" class="form-control" name="Adresse" id="Adresse" /><br>
                        Kategori: <select class="form-control" name="Kategori" id="Kategori">
                            <?php
                                // Itererer over alle kategoriene hentet fra DB
                                foreach ($kategorier as $kategori)
                                    {echo "<option value='".$kategori['Kategori_navn']."'>".$kategori['Kategori_navn']."</option>";}
                            ?>
                        </select><br>
                        Telefonnummer: <input type="text" class="form-control" name="Telefon" id="Telefon" /><br>
                        Beskrivelse: <textarea rows="5" class="form-control" name="Beskrivelse" id="Beskrivelse"></textarea><br>
                        Åpningstider: <input type="text" class="form-control" name="Åpningstider" id="Åpningstider" /><br>
                        Nettside: <input type="text" class="form-control" name="Nettside" id="Nettside" /><br>
                        <input type="submit" class="btn btn-info pull-right" style="margin-top: 10px;" value="Registrer bedrift">
                        <label class="btn btn-default">Last opp bilde <input type="file" hidden>
                        </label>
                      </form>
                    </div>            
        </div>

        <div class="col-lg-7">
          <h4>Lokasjon - Google Maps</h4>
          <p>Din lokasjon vil oppdateres når du skriver inn adressen.</p>
          <iframe
            id="kartNyBedrift"
            width="600"
            height="450"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/search?key=AIzaSyDywUZI16jpELxuAZ6VFnNtaGyElz-DQ-k&q=Westerdals, Oslo" allowfullscreen>
          </iframe>
        </div>         
      </div>
        
    </div> <!-- /container -->

<!-- Link til jQuery Script for dynamisk oppdatering av adresse i kartet -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script  type="text/javascript">
jQuery(
  function($)
  {
       var q=encodeURIComponent($('#Adresse').value());
       $('#kartNyBedrift')
        .attr('src',
             'https://www.google.com/maps/embed/v1/search?key=AIzaSyDywUZI16jpELxuAZ6VFnNtaGyElz-DQ-k&q='+q);

  }
);
</script>

</body>
</html>