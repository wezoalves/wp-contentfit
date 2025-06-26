# Documentação do Plugin WP Content Fit

## Visão Geral

O **WP Content Fit** é um plugin para WordPress projetado especificamente para sites com foco em fitness e bem-estar. Ele capacita os administradores de sites a criar Tipos de Post Personalizados (CPTs) que se alinham perfeitamente com conteúdo sobre saúde, exercícios físicos, nutrição e um estilo de vida saudável. A principal proposta do plugin é facilitar a organização e apresentação de informações especializadas de forma estruturada e amigável ao usuário.

## Funcionalidades Principais

-   **Criação de Tipos de Post Personalizados (CPTs)**: Oferece CPTs pré-definidos e otimizados para o nicho de fitness e bem-estar.
-   **Campos Personalizados Avançados**: Permite adicionar informações detalhadas e específicas para cada tipo de conteúdo, melhorando a riqueza dos dados.
-   **API REST Integrada**: Fornece endpoints para os CPTs de `Cupom` e `Alimento`, permitindo a integração com sistemas externos ou aplicações front-end customizadas.
-   **Interface Administrativa Intuitiva**: Garante que o gerenciamento dos CPTs e seus respectivos campos seja simples e direto no painel do WordPress.
-   **Integração com Plataformas de Afiliados**: Possui módulos para conectar-se com diversas redes de afiliados, facilitando a monetização de conteúdo.
-   **Extensibilidade**: Projetado com a possibilidade de adicionar novos CPTs conforme a necessidade, seguindo um padrão de desenvolvimento claro.

## Tipos de Post Personalizados (CPTs) Detalhados

O plugin introduz os seguintes CPTs, cada um com seus campos e finalidades específicas:

1.  **Tênis (`slug: tenis`)**
    *   **Descrição**: Ideal para catalogar, analisar e comparar diferentes modelos de tênis esportivos. Muito útil para sites que publicam reviews, guias de compra ou comparativos de performance.
    *   **Campos Personalizados Típicos**: Modelo, marca, tipo de pisada (pronada, supinada, neutra), amortecimento, drop, peso, preço médio, URL de afiliado para compra, galeria de imagens, avaliação do usuário/editor.

2.  **Loja (`slug: loja`)**
    *   **Descrição**: Permite criar um diretório de lojas físicas ou online que oferecem produtos e serviços relacionados ao universo fitness e bem-estar.
    *   **Campos Personalizados Típicos**: Nome da loja, descrição, endereço físico (se aplicável), website, contato (telefone, e-mail), categorias de produtos (suplementos, vestuário, equipamentos), horários de funcionamento, logomarca.

3.  **Alimento (`slug: alimento`)**
    *   **Descrição**: Focado no registro detalhado de informações nutricionais sobre diversos alimentos, receitas ou suplementos. Essencial para portais de nutrição, dietas e vida saudável.
    *   **Campos Personalizados Típicos**: Nome do alimento, descrição, tabela nutricional completa (calorias, macronutrientes, micronutrientes), porção de referência, categoria (fruta, vegetal, grão, suplemento), benefícios à saúde, possíveis alérgenos.

4.  **Cupom (`slug: coupon`)**
    *   **Descrição**: Gerencia a publicação de cupons de desconto para produtos ou serviços de lojas parceiras. Este CPT é crucial para estratégias de marketing de afiliados e promoções. (Nota: A existência deste CPT é inferida pela API e estrutura de código, sendo uma funcionalidade central).
    *   **Campos Personalizados Típicos**: Código do cupom, título da promoção, descrição detalhada da oferta, loja associada (link para o CPT Loja), URL de destino (link de afiliado), data de início e validade, percentual ou valor do desconto, imagem promocional.

## Estrutura do Projeto

O projeto está organizado da seguinte forma:

-   **`api/`**: Contém a lógica para a API REST do plugin.
    -   `Coupon.php`: Define os endpoints para o CPT de Cupom.
    -   `Food.php`: Define os endpoints para o CPT de Alimento.
    -   `Request.php`: Classe base para manipulação de requisições da API, incluindo autenticação.
-   **`assets/`**: Contém os recursos estáticos.
    -   `css/review-style.css`: Folha de estilos para os campos personalizados e outros elementos visuais do plugin na área administrativa.
-   **`src/`**: Contém o código-fonte principal do plugin.
    -   **`Affiliate/`**: Classes para integração com diferentes plataformas de afiliados (Actionpay, Afilio, Amazon, Awin, Rakuten, Socialsoul).
    -   **`Domain/`**: Entidades de domínio como `AffiliateOffer` e `BestOffer`.
    -   **`Interface/`**: Interfaces PHP que definem contratos para diferentes partes do sistema (API, CPTs, Elementos, Programas, Repositórios).
    -   **`Model/`**: Modelos de dados que representam as entidades do plugin (AffiliateProgram, Coupon, Food, Store, Tenis, etc.).
    -   **`Repository/`**: Classes responsáveis pelo acesso e manipulação dos dados no banco de dados do WordPress (Coupon, Food, Store, Tenis, User).
    -   **`Utils/`**: Classes utilitárias para diversas funcionalidades (RatingTenis, Redirect, SchemaNutrition, Type, Url, etc.).
    -   **`WordPress/`**: Código específico para a integração com o WordPress.
        -   `CustomPostType/`: Define a estrutura e o comportamento dos CPTs (Coupon, Foods, Store, Tenis).
        -   `Elements/`: Classes para renderizar diferentes tipos de campos de formulário na administração (Text, Select, Range, etc.).
        -   `Fields/`: Define os campos personalizados para cada CPT (Coupon, Foods, Store, Tenis).
    -   `Init.php`: Ponto de entrada para inicializar as funcionalidades do plugin no WordPress, registrando os CPTs e hooks necessários.
    -   `README.md`: Instruções para desenvolvedores sobre como adicionar novos CPTs ao plugin.
-   **`README.md` (raiz)**: Arquivo principal com a descrição geral do plugin e instruções básicas de instalação para usuários.
-   **`composer.json`**: Arquivo de configuração para o gerenciador de dependências Composer. No momento da análise, não possuía dependências externas listadas.
-   **`review.php`**: Arquivo principal do plugin, responsável por carregar todas as funcionalidades e ser o ponto de entrada que o WordPress utiliza para reconhecer e ativar o plugin.

## Instruções de Instalação

### Via Terminal

1.  Navegue até o diretório de plugins do seu WordPress:
    ```bash
    cd /caminho_do_wordpress/wp-content/plugins/
    ```
2.  Clone o repositório:
    ```bash
    git clone git@github.com:wezoalves/wp-contentfit.git
    ```

### Via Painel Administrativo do WordPress

1.  Acesse o painel administrativo do WordPress.
2.  Navegue até "Plugins" > "Plugins Instalados".
3.  Procure na lista por: **WezoAlves - Content Fit**.
4.  Clique no link "Ativar".

Após a ativação do plugin, os novos CPTs aparecerão no menu geral do WordPress:

-   Lojas (`/wp-admin/edit.php?post_type=loja`)
-   Tênis (`/wp-admin/edit.php?post_type=tenis`)
-   Alimento (`/wp-admin/edit.php?post_type=alimento`)
-   (Cupons provavelmente terão uma entrada similar, ex: `/wp-admin/edit.php?post_type=coupon`)

## API REST

O plugin expõe uma API REST robusta para permitir a interação programática com os CPTs de `Cupom` e `Alimento`. Isso é particularmente útil para integrações com aplicativos móveis, front-ends desacoplados (headless WordPress) ou para automatizar a entrada de dados.

-   **Autenticação**: A API utiliza autenticação **Basic Auth**. As credenciais (nome de usuário e senha do WordPress) devem ser codificadas em Base64 e enviadas no cabeçalho `Authorization` de cada requisição.
    ```
    Authorization: Basic <base64_encode(username:password)>
    ```
-   **Namespace da API**: Todas as rotas da API estão sob o namespace `api/v1`.
-   **Formato de Resposta**: As respostas são geralmente em formato JSON.

### Endpoints de Cupom (`/api/v1/coupon`)

-   **`POST /add`**: Cria ou atualiza um cupom.
    -   **Parâmetros Principais**:
        -   `coupon_promotionId` (validador, ID da promoção)
        -   `title` (título do cupom)
        -   `description` (descrição)
        -   `store_url` (URL da loja para associar o cupom)
        -   Outros campos definidos em `Review\WordPress\Fields\Coupon`
-   **`GET /get/{id}`**: Obtém um cupom específico pelo seu ID do WordPress.
-   **`GET /list`**: Lista os cupons.
    -   **Parâmetros Opcionais**: `page`, `per_page`, `search_term`.

### Endpoints de Alimento (`/api/v1/food`)

-   **`POST /add`**: Cria ou atualiza um alimento.
    -   **Parâmetros Principais**:
        -   `alimento_id` (validador, ID do alimento)
        -   `title` (nome do alimento)
        -   `description` (descrição/excerto)
        -   Outros campos definidos em `Review\WordPress\Fields\Foods`
-   **`GET /get/{id}`**: Obtém um alimento específico pelo seu ID do WordPress.
-   **`GET /list`**: Lista os alimentos.
    -   **Parâmetros Opcionais**: `page`, `per_page`, `search_term`.
-   **`GET /delete`**: Remove todos os posts do tipo "Alimento". (Cuidado: esta ação é destrutiva e remove todos os alimentos).

## Recursos Estáticos

-   **`assets/css/review-style.css`**: Contém estilos CSS para a apresentação dos campos personalizados na área de administração do WordPress, melhorando a interface de usuário ao editar os CPTs.

## Como Adicionar Novos Tipos de Post Personalizados (CPTs)

O arquivo `src/README.md` fornece um guia detalhado para desenvolvedores sobre como estender o plugin com novos CPTs. O processo envolve a criação de classes nos seguintes diretórios:

-   `src/Model/{NomeDoCPT}.php`: Define o modelo de dados para o novo CPT.
-   `src/WordPress/CustomPostType/{NomeDoCPT}.php`: Registra o novo CPT no WordPress e define seus labels, ícone, suporte a funcionalidades, etc.
-   `src/WordPress/Fields/{NomeDoCPT}.php`: Define os campos personalizados para o novo CPT.
-   `src/Repository/{NomeDoCPT}.php`: Cria um repositório para buscar e manipular dados do novo CPT.

É importante seguir a estrutura e os exemplos fornecidos no `src/README.md` para manter a consistência do código.
