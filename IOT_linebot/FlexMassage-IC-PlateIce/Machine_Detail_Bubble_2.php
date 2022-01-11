

<?php
$jsonflex = 
[
  "type"=> "flex",
  "altText"=> "Flex Message",
  "contents"=> [
    "type"=> "bubble",
    "hero"=> [
      "type"=> "image",
      "url"=> "https://patkolpae.com/IOT_linebot/images/Banner_Machine_PlateIce.jpg",
      "size"=> "full",
      "aspectRatio"=> "20:13",
      "aspectMode"=> "cover"
    ],
    "body"=> [
      "type"=> "box",
      "layout"=> "vertical",
      "spacing"=> "md",
      "contents"=> [
        [
          "type"=> "text",
          "text"=> $site_name,
          "size"=> "xl",
          "align"=> "center",
          "weight"=> "bold",
          "color"=> "#000000"
        ],
        [
          "type"=> "text",
          "text"=> $machine_desc,
          "margin"=> "sm",
          "size"=> "lg",
          "align"=> "center",
          "color"=> "#000000",
          "wrap"=> true
        ],
        [
          "type"=> "box",
          "layout"=> "vertical",
          "margin"=> "lg",
          "contents"=> [
          ]
        ]
      ]
    ]
  ]
]

?>