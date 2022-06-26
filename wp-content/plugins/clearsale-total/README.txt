=== ClearSale Total ===
Contributors:
Donate link: 
Tags: woocommerce, clearsale, anti-fraude
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integração do WooComerce com a ClearSale.
testado: wordpress 4.9.8
woocommerce 3.4.5
Requisitos:
php 5.4.x ou maior
cURL

== Description ==

Esta solução implementa a verificação de fraude em toda compra feita por esta loja, se o plugin do PagSeguro
estiver instalado, os dados do cartão serão passados junto com o pedido para aprimorar a análise. Todo pedido
incluído na ClearSale recebe status de "Em Análise" e é salvo em "Notas" do pedido. Após a análise o status
é alterado, podendo o lojista consultar pelo Grid de pedidos ou no corpo do pedido.

== Installation ==

Certifique-se de que não há instalação de outros módulos da ClearSale em seu sistema;
Baixe o arquivo clearsale-total.zip;
Na área administrativa de seu WordPress acesse o menu Plugins -> Adicionar Novo -> Enviar/Fazer upload do plugin ->
->escolher arquivo, ache o caminho do arquivo clearsale-total.zip e selecione Instalar Agora;
Após a instalação selecione Ativar plugin;

== Configurations ==

Para acessar "CONFIGURAÇÕES" do módulo acesse, na área administrativa de seu WordPress, Configurações -> ClearSale Total.
 
As opções disponíveis estão descritas abaixo.

    Selecione entre ambiente de teste e produção (Defina se está no modo homologação ou produção)

    Digite login e senha fornecidos pela ClearSale
 
    Digite o Fingerprint fornecido pela ClearSale, 
        Você deve ter um número parecido com este: a6s8h29ym6xgm5qor3sk

    Informar a URL que aparece no final da tela de configuração para a ClearSale, com isto a loja recebe as aprovações de compras
    analisadas.


== Frequently Asked Questions ==



== Screenshots ==

== Changelog ==
Para consultar o log de alterações acesse o arquivo [CHANGELOG.md](CHANGELOG.md).

== Arbitrary section ==

