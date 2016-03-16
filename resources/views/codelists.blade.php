
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Onix codelists</title>

  <!-- Bootstrap core CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="container">
        <div class="jumbotron">
          <h1>Onix codelists</h1>
        </div> 

        <table class="table table-condensed table-hover">
          <thead>
            <tr>
              <th>Number</th>
              <th>Description</th>
              <th>Issue number</th>
              <th>Code values</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($codelists as $codelist)
            <tr class='clickable-row' data-href='url://www.fi'>
              <td>{{ $codelist->number }}</td>
              <td>{{ $codelist->description }}</td>
              <td>{{ $codelist->issue_number }}</td>
              <td><a href="{{ route('codelist.show', ['number' => $codelist->number]) }}">Link</a></td>
            </tr>
            @endforeach            
          </tbody>
        </table>

        {!! $codelists->render() !!}
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      </body>
      </html>
