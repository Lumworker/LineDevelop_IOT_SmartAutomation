
<?php
$jsonflex = [
  "type" => "flex",
  "altText" => "Flex Message",
  "contents" => [
      "type" => "bubble",
      "direction" => "ltr",
      "header" => [
          "type" => "box",
          "layout" => "vertical",
          "contents" => [
              [
                  "type" => "text",
                  "text" => "แจ้งยอดการผลิต",
                  "weight" => "bold",
                  "size" => "lg",
                  "align" => "center",
                  "contents" => []
              ]
          ]
      ],
      "footer" => [
          "type" => "box",
          "layout" => "horizontal",
          "contents" => [
              [
                  "type" => "button",
                  "action" => [
                      "type" => "uri",
                      "label" => "Click",
                      "uri" => "https://liff.line.me/1656699401-oONYw7jz?x=xxxx&Role=Operator&trans_id=0"
                  ],
                  "style" => "primary"
              ]
          ]
      ]
  ]
];

?>