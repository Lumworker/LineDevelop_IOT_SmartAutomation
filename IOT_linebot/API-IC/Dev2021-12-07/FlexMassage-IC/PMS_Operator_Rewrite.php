

<?php
$jsonflex = [
  "type" => "flex",
  "altText" => "Flex Message",
  "contents" => 
  [
    "type"=> "bubble",
    "direction"=> "ltr",
    "body"=> [
      "type"=> "box",
      "layout"=> "vertical",
      "contents"=> [
        [
          "type"=> "text",
          "text"=> "แก้ไขยอดการผลิต : ".$trans_id,
          "weight"=> "bold",
          "size"=> "xl",
          "align"=> "center",
          "contents"=> []
        ],
        [
          "type"=> "text",
          "text"=> "หมายเลขการผลิต : ".$trans_id ,
          "size"=> "md",
          "align"=> "center",
          "margin"=> "lg",
          "contents"=> []
        ]
      ]
    ],
    "footer"=> [
      "type"=> "box",
      "layout"=> "horizontal",
      "contents"=> [
        [
          "type"=> "button",
          "action"=> [
            "type"=> "message",
            "label"=> "เรียกคืนการแจ้ง",
            "text"=> "Operator : ยืนยันแก้ไขยอดการผลิต : ".$trans_id 
          ],
          "color"=> "#dc3545",
          "style"=> "primary"
        ],
        [
          "type"=> "separator",
          "margin"=> "md"
        ],
        [
          "type"=> "button",
          "action"=> [
            "type"=> "uri",
            "label"=> "ดูยอดการผลิต",
            "uri"=> "https://liff.line.me/1656699401-oONYw7jz?x=xxxxx&Role=Operator&trans_id=".$trans_id 
          ],
          "color"=> "#24A0ED",
          "style"=> "primary"
        ]
      ]
    ]
  ]
];

?>