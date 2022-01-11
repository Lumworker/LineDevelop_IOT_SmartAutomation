
<?php
$jsonFlex = [
  "type" => "flex",
  "altText" => "Flex Message",
  "contents" => [
    "type" => "bubble",
    "body" => [
      "type" => "box",
      "layout" => "vertical",
      "spacing" => "sm",
      "contents" => [
        [
          "type" => "text",
          "text" => "เลือกความช่วยเหลือได้เลยครับ",
          "size" => "lg",
          "align" => "start",
          "weight" => "regular",
          "wrap" => true
        ]
      ]
    ],
    "footer" => [
      "type" => "box",
      "layout" => "vertical",
      "spacing" => "sm",
      "contents" => [
        [
          "type" => "box",
          "layout" => "horizontal",
          "contents" => [
            [
              "type" => "button",
              "action" => [
                "type" => "uri",
                "label" => "คู่มือ",
                "uri" => $url1
              ],
              "color" => "#0F4DB6",
              "margin" => "sm",
              "height" => "sm",
              "style" => "primary"
            ],
            [
              "type" => "button",
              "action" => [
                "type" => "uri",
                "label" => "วีดีโอ",
                "uri" => $url2
              ],
              "color" => "#0F4DB6",
              "margin" => "sm",
              "height" => "sm",
              "style" => "primary"
            ]
          ]
        ]
      ]
    ]
  ]
];

$jsonFlex2 = [
  "type" => "flex",
  "altText" => "Flex Message",
  "contents" => [
    "type" => "bubble",
    "body" => [
      "type" => "box",
      "layout" => "vertical",
      "spacing" => "sm",
      "contents" => [
        [
          "type" => "text",
          "text" => "ความช่วยเหลือข้างต้น สามารถช่วยได้ไหมครับ",
          "align" => "start",
          "size" => "lg",
          "weight" => "regular",
          "wrap" => true
        ]
      ]
    ],
    "footer" => [
      "type" => "box",
      "layout" => "vertical",
      "spacing" => "sm",
      "contents" => [
        [
          "type" => "box",
          "layout" => "horizontal",
          "contents" => [
            [
              "type" => "button",
              "action" => [
                "type" => "message",
                "label" => "ได้",
                "text" => "รับทราบครับ"
              ],
              "color" => "#0F4DB6",
              "margin" => "sm",
              "height" => "sm",
              "style" => "primary"
            ],
            [
              "type" => "button",
              "action" => [
                "type" => "message",
                "label" => "ไม่ได้",
                "text" => $text3
              ],
              "color" => "#7D7F83",
              "margin" => "sm",
              "height" => "sm",
              "style" => "primary"
            ]
          ]
        ]
      ]
    ]
  ]
];
?>