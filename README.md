# semantic-release

> Repositório para testar workflow com semantic-release

## Tecnologias Utilizadas

- [Semantic Release](https://github.com/semantic-release/semantic-release)

## Como configurar?

**ATENÇÃO:** Não deixe de conferir a [documentação oficial](https://semantic-release.gitbook.io/semantic-release) da ferramenta.

Por padrão, a ferramenta busca por um arquivo de configuração na raiz do projeto com o nome de .releaserc, escritas em YAML ou JSON, podendo ou não ter extensão. [Mais detalhes](https://semantic-release.gitbook.io/semantic-release/usage/configuration)

Nesta prova de conceito (POC), utilizamos o seguinte:

<!-- prettier-ignore-start -->
```json
// .releaserc.json
"branches": ["main"],
  "plugins": [
    "@semantic-release/commit-analyzer",
    [
      "@semantic-release/release-notes-generator",
      {
        "presetConfig": {
          "types": [
            { "type": "feat", "section": "Features" },
            { "type": "fix", "section": "Bug Fixes" },
            { "type": "chore", "section": "Miscellaneous" },
            { "type": "docs", "section": "Documentation" },
            { "type": "refactor", "section": "Refactoring" },
            { "type": "perf", "section": "Performance" },
            { "type": "test", "section": "Testing" }
          ]
        }
      }
    ],
    "@semantic-release/changelog",
    [
      "@semantic-release/github",
      {
        "assignees": "renebentes"
      }
    ],
    [
      "@semantic-release/exec",
      {
        "prepareCmd": "echo ${nextRelease.version} > version.txt"
      }
    ],
    [
      "@semantic-release/git",
      {
        "assets": ["CHANGELOG.md", "version.txt"]
      }
    ]
  ],
  "preset": "conventionalcommits"
```
<!-- prettier-ignore-end -->

## Autor

[Rene Bentes Pinto](http://github.com/renebentes)

## Contribuindo

Contribuições são bem-vindas!

Se você achar algum problema ou tiver sugestões para melhorias, por favor, abra uma [_Issue_][issues] ou envie uma [_Pull Request (PR)_][pulls] para nosso [repositório][repo].

Você também pode verificar as _Issues_ e _Pull Requests_ existentes com os quais poderia ajudar.

Ao contribuir com este projeto, por favor, siga o estilo de codificação existente, use [conventional commits][commits] em suas mensagens de commit e submeta suas alterações em uma branch separada.

## Notas de Lançamento

Você pode [ver as notas de lançamento aqui.](CHANGELOG.md)

## Licença

Copyright (c) 2024 Rene Bentes Pinto

Este projeto está sob a licença **MIT**. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

[repo]: http://github.com/renebentes/repository
[issues]: ../../issues
[pulls]: ../../pulls
[commits]: https://www.conventionalcommits.org/en/v1.0.0/
