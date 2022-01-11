

<?php
$jsonflex = 
[
  "type"=> "flex",
  "altText"=> "Flex Message",
  "contents"=> [
    "type"=> "bubble",
    "hero"=> [
      "type"=> "image",
      "url"=> "https://patkolpae.com/IOT_linebot/images/Patkol_315.jpg",
      "size"=> "full",
      "aspectRatio"=> "20:13",
      "aspectMode"=> "cover"
    ],
    "body"=> [
      "type"=> "box",
      "layout"=> "vertical",
      "spacing"=> "md",
      "action"=> [
        "type"=> "uri",
        "label"=> "Action",
        "uri"=> "https://linecorp.com"
      ],
      "contents"=> [
        [
          "type"=> "text",
          "text"=> $site_name,
          "size"=> "xl",
          "align"=> "center",
          "weight"=> "bold"
        ],
        [
          "type"=> "text",
          "text"=> $machine_desc,
          "color"=> "#707070",
          "align"=> "center",
          "wrap"=> true
        ]
      ]
    ],
    "footer"=> [
      "type"=> "box",
      "layout"=> "vertical",
      "contents"=> [
      
      ]
    ]
  ]
]

?>