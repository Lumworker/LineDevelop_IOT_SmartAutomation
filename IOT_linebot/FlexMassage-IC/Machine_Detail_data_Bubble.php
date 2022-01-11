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
          "text"=> $row['main_machine_desc'],
          "size"=>"xl",
          "gravity"=>"top",
          "weight"=>"bold"
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