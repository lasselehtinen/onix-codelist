
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Onix codelists - List {{ $codelist->number }}: {{ $codelist->description }}</title>

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
          <h1>List {{ $codelist->number }}: {{ $codelist->description }}</h1>
        </div> 

        <table class="table table-condensed table-hover">
          <thead>
            <tr>
              <th>Value</th>
              <th>Description</th>
              <th>Notes</th>
              <th>Issue number</th>              
            </tr>
          </thead>
          <tbody>
            @foreach ($codelist->codes as $code)
            <tr>
              <td>{{ $code->value }}</td>
              <td>{{ $code->description }}</td>
              <td>{{ $code->notes }}</td>
              <td>{{ $code->issue_number }}</td>
            </tr>
            @endforeach            
          </tbody>
        </table>

        <a href="{{ URL::previous() }}">Back to Codelists</a>

      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
    </html>
