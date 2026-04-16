<?php

require 'api.php';

$tipo   = $_GET['tipo']   ?? 'cars';
$marca  = $_GET['marca']  ?? '';
$modelo = $_GET['modelo'] ?? '';
$ano    = $_GET['ano']    ?? '';

$marcas  = fetchFipe("$tipo/brands");
$modelos = $marca  ? fetchFipe("$tipo/brands/$marca/models") : [];
$anos    = ($marca && $modelo) ? fetchFipe("$tipo/brands/$marca/models/$modelo/years") : [];
$preco   = ($marca && $modelo && $ano) ? fetchFipe("$tipo/brands/$marca/models/$modelo/years/$ano") : null;

$tipoLabel = ['cars' => 'Carros', 'motorcycles' => 'Motos', 'trucks' => 'Caminhões'];
$combustivel = ['G' => '⛽ Gasolina', 'D' => '🛢️ Diesel', 'E' => '🌿 Etanol'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Consulta Tabela FIPE</title>
  <meta name="description" content="Consulte o preço médio de veículos, motos e caminhões na Tabela FIPE." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="container">

  <header>
    <div class="badge">🚗 Tabela FIPE</div>
    <h1>Consulta <span>FIPE</span></h1>
    <p>Descubra o preço médio de veículos no mercado nacional, com dados atualizados mensalmente.</p>
  </header>

  <div class="card">


    <div class="type-tabs">
      <?php foreach (['cars' => ['🚗', 'Carros'], 'motorcycles' => ['🏍️', 'Motos'], 'trucks' => ['🚚', 'Caminhões']] as $valor => $info): ?>
        <a href="?tipo=<?= $valor ?>"
           class="type-tab <?= $tipo === $valor ? 'active' : '' ?>">
          <span class="icon"><?= $info[0] ?></span>
          <span class="label"><?= $info[1] ?></span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="steps">


      <div class="step active">
        <div class="step-label">
          <span class="step-num">1</span>
          Marca
        </div>
        <form method="GET" action="">
          <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
          <div class="select-wrapper">
            <select name="marca" onchange="this.form.submit()">
              <option value="">Selecione a marca...</option>
              <?php foreach ($marcas as $m): ?>
                <option value="<?= $m['code'] ?>" <?= $marca == $m['code'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($m['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="select-arrow">▾</span>
          </div>
        </form>
      </div>

      <div class="divider"></div>


      <div class="step <?= $marca ? 'active' : '' ?>">
        <div class="step-label">
          <span class="step-num">2</span>
          Modelo
        </div>
        <form method="GET" action="">
          <input type="hidden" name="tipo"  value="<?= htmlspecialchars($tipo) ?>">
          <input type="hidden" name="marca" value="<?= htmlspecialchars($marca) ?>">
          <div class="select-wrapper">
            <select name="modelo" <?= !$marca ? 'disabled' : '' ?> onchange="this.form.submit()">
              <option value="">Selecione o modelo...</option>
              <?php foreach ($modelos as $m): ?>
                <option value="<?= $m['code'] ?>" <?= $modelo == $m['code'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($m['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="select-arrow">▾</span>
          </div>
        </form>
      </div>

      <div class="divider"></div>


      <div class="step <?= ($marca && $modelo) ? 'active' : '' ?>">
        <div class="step-label">
          <span class="step-num">3</span>
          Ano / Combustível
        </div>
        <form method="GET" action="">
          <input type="hidden" name="tipo"   value="<?= htmlspecialchars($tipo) ?>">
          <input type="hidden" name="marca"  value="<?= htmlspecialchars($marca) ?>">
          <input type="hidden" name="modelo" value="<?= htmlspecialchars($modelo) ?>">
          <div class="select-wrapper">
            <select name="ano" <?= !($marca && $modelo) ? 'disabled' : '' ?> onchange="this.form.submit()">
              <option value="">Selecione o ano...</option>
              <?php foreach ($anos as $a): ?>
                <option value="<?= $a['code'] ?>" <?= $ano == $a['code'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($a['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="select-arrow">▾</span>
          </div>
        </form>
      </div>

    </div>

  </div>
  <?php if ($preco): ?>
  <div id="result" style="display:block;">
    <div class="result-card">
      <div class="result-label">Preço médio FIPE</div>
      <div class="result-price"><?= htmlspecialchars($preco['price']) ?></div>
      <div class="result-grid">
        <div class="result-item">
          <div class="ri-label">Marca</div>
          <div class="ri-value"><?= htmlspecialchars($preco['brand']) ?></div>
        </div>
        <div class="result-item">
          <div class="ri-label">Modelo</div>
          <div class="ri-value"><?= htmlspecialchars($preco['model']) ?></div>
        </div>
        <div class="result-item">
          <div class="ri-label">Ano</div>
          <div class="ri-value"><?= $preco['modelYear'] ?></div>
        </div>
        <div class="result-item">
          <div class="ri-label">Combustível</div>
          <div class="ri-value"><?= $combustivel[$preco['fuelAcronym']] ?? $preco['fuel'] ?></div>
        </div>
        <div class="result-item">
          <div class="ri-label">Referência</div>
          <div class="ri-value"><?= htmlspecialchars($preco['referenceMonth']) ?></div>
        </div>
      </div>
      <div class="fipe-code">🏷️ Código FIPE: <?= htmlspecialchars($preco['codeFipe']) ?></div>
    </div>
  </div>
  <?php endif; ?>

</div>

<footer>
  Dados fornecidos pela <a href="https://fipe.online" target="_blank" rel="noopener">API FIPE Online</a>
  · Atualização mensal
</footer>

</body>
</html>
