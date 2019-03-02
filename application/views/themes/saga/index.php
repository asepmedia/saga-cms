<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <!-- Header -->
  <?= $this->saga->theme->header();?>
</head>
<body>
  <?php $this->saga->theme->partial($view);?>
</body>
</html>