

<?php
$jsonflex = 
[
  "type"=> "flex",
  "altText"=> "Flex Message",
  "contents"=> [
    "type"=> "carousel",
    "contents"=> [
      [
        "type"=> "bubble",
        "direction"=> "ltr",
        "hero"=> [
          "type"=> "image",
          "url"=> "https://www.img.in.th/images/79ed95b7b327372635bd1c8dac040b61.jpg",
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
              "text"=> "โรงน้ำแข็ง -1",
              "size"=> "xl",
              "align"=> "center",
              "weight"=> "bold",
              "color"=> "#000000"
            ],
            [
              "type"=> "text",
              "text"=> "เลือกเครื่องทำน้ำแข็งที่ต้องการ",
              "margin"=> "sm",
              "size"=> "lg",
              "align"=> "center",
              "color"=> "#000000"
            ],
            [
              "type"=> "box",
              "layout"=> "vertical",
              "margin"=> "lg",
              "contents"=> [
                [
                  "type"=> "button",
                  "action"=> [
                    "type"=> "message",
                    "label"=> "เครื่องจักร1",
                    "text"=> "เครื่องจักร1"
                  ],
                  "color"=> "#000D7F",
                  "margin"=> "sm",
                  "height"=> "sm",
                  "style"=> "primary"
                ]
              ]
            ]
          ]
        ],
        "styles"=> [
          "hero"=> [
            "backgroundColor"=> "#FFFFFF"
          ],
          "body"=> [
            "backgroundColor"=> "#FFFFFF"
          ]
        ]
      ]
    ]
  ]
]
?>