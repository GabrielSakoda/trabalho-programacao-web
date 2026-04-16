# Consulta Tabela FIPE

Projeto PHP para consultar o preço médio de veículos na Tabela FIPE, utilizando a [API FIPE Online](https://fipe.online).

## Funcionalidades

- Consulta de **carros**, **motos** e **caminhões**
- Seleção progressiva: marca → modelo → ano/combustível
- Exibe preço médio, código FIPE e mês de referência

## Tecnologias

- PHP (cURL)
- HTML + CSS

## Como rodar

1. Instale o PHP com suporte a cURL:
   ```bash
   sudo apt install php php-curl
   ```

2. Inicie o servidor local:
   ```bash
   php -S localhost:8787
   ```

3. Acesse no navegador: `http://localhost:8787`

## Estrutura

```
fipe-consulta/
├── index.php   # Página principal e lógica PHP
├── api.php     # Função fetchFipe() via cURL
└── style.css   # Estilos
```

## API utilizada

[https://fipe.parallelum.com.br/api/v2/](https://deividfortuna.github.io/fipe/v2/)
