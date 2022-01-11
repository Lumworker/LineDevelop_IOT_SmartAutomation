<?php
$jsonflex = 
[
  "type"=>"flex",
  "altText"=>"Flex Message",
  "contents"=>[
    "type"=>"bubble",
    "direction"=>"ltr",
    "hero"=>[
      "type"=>"image",
      "url"=>"https://patkolpae.com/IOT_linebot/Images/TI1.png",
      "align"=>"center",
      "size"=> "full",
      "aspectRatio"=> "1.51:1",
      "aspectMode"=> "fit"
    ],
    "body"=>[
      "type"=>"box",
      "layout"=>"vertical",
      "contents"=>[
        [
          "type"=>"text",
          "text"=> $arrayDB[0][5],
          "size"=>"xl",
          "gravity"=>"top",
          "weight"=>"bold"
        ],
        [
          "type"=>"box",
          "layout"=>"baseline",
          "margin"=>"md",
          "contents"=>[
            [
              "type"=>"text",
              "text"=>"เลือกเครื่องทำน้ำแข็งที่ต้องการ",
              "size"=>"md",
              "align"=>"start",
              "gravity"=>"top",
              "weight"=>"bold"
            ]
          ]
        ]
      ]
    ],
    "footer"=>[
      "type"=>"box",
      "layout"=>"vertical",
      "flex"=>0,
      "spacing"=>"sm",
      "contents"=>[
       
      ]
    ],
    "styles"=>[
      "hero"=>[
        "separatorColor"=>"#FFFFFF"
      ]
    ]
  ]
];

?>