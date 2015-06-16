<!DOCTYPE html>
<head>
  <title>Registratie kweerkactiviteiten</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Registratie kweekactiviteiten</h2>
  <form role="form">
    <div class="form-group">
      <label for="datum">Datum:</label>
      <input type="date" class="form-control" id="datum">
    </div>
    <div class="form-group">
	  <label for="activiteit">Activiteit:</label>
	  <select class="form-control" id="activiteit">
	    <option >Zaaien</option>
		<option >Verzaaien</option>
		<option >Sterren dweilen</option>
		<option >Sterren rollen</option>
		<option >Uitvissen</option>
		<option >Bijzaaien</option>
		<option >Trekje op perceel</option>
		<option >Anders</option>
	  </select>
	</div>
	<div class="form-group">
      <label for="perceel_naam">Perceel naam: </label>
      <input type="text" class="form-control" id="perceel_naam">
    </div>
    <div class="form-group">
      <label for="perceel_plaats">Perceel plaats: </label>
      <input type="text" class="form-control" id="perceel_plaats">
    </div>
    <div class="form-group">
	  <label for="gezaaid_als">Gezaaid als:</label>
	  <select class="form-control" id="gezaaid_als">
		<option >MZI WAD</option>
		<option >NJZAAD</option>
		<option >VJZAAD</option>
		<option >HalfwasOS</option>
		<option >HalfwasWAD</option>
		<option >Consumptie</option>
		<option >Anders</option>
	  </select>
	</div>
	 <div class="form-group">
      <label for="oppervlakte">Oppervlakte: </label>
      <input type="text" class="form-control" id="oppervlakte">
    </div>
    <div class="row spacer">
   		<div class="span4"> </div>
   	</div>
   	<br>
   	<br>
   	<div class="form-group">
	  <label for="monster">Monster:</label>
	  <select class="form-control" id="monster">
	    <option >Ja</option>
		<option >Nee</option>
	  </select>
	</div>
	<div class="form-group">
      <label for="label">Label: </label>
      <input type="text" class="form-control" id="label">
    </div>
    <br>
    <br>
    <div class="form-group">
      <label for="label">Verzaaien </label>
    </div>
    <div class="form-group">
      <label for="perceel_naam_verzaaien">Perceel naam: </label>
      <input type="text" class="form-control" id="perceel_naam_verzaaien">
    </div>
    <div class="form-group">
      <label for="perceel_plaats_verzaaien">Perceel plaats: </label>
      <input type="text" class="form-control" id="perceel_plaats_verzaaien">
    </div>
    <div class="form-group">
      <label for="oppervlakte_verzaaien">Oppervlakte: </label>
      <input type="text" class="form-control" id="oppervlakte_verzaaien">
    </div>
    <br>
    <br>
    <div class="form-group">
      <label for="label">Indien van toepassing </label>
    </div>
    <div class="form-group">
      <label for="busstukstal">Busstukstal: </label>
      <input type="text" class="form-control" id="busstukstal">
    </div>
    <div class="form-group">
      <label for="mosselton">Mosselton: </label>
      <input type="text" class="form-control" id="mosselton">
    </div>
    <div class="form-group">
	  <label for="perceel_leeggevist">Perceel leeggevist?</label>
	  <select class="form-control" id="perceel_leeggevist">
	    <option >Ja</option>
		<option >Nee</option>
	  </select>
	</div>
    <div class="form-group">
 	 <label for="opmerkingen">Opmerkingen:</label>
 	 <textarea class="form-control" rows="5" id="opmerkingen"></textarea>
	</div>
  </form>
</div>

</body>
</html>