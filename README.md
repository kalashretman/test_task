# test_task

Данное АПИ позволяет Вам:

  1. получить список картинок, который загрузил userID
  2. получить resize картинки с размерами width и height
  
Для получения списка необходимо:
  - отправить POST-запросом на http://test_task/resize :
    1  идентификатор клиента userID
    2. файл картинки
    3. необходимые размеры для resize картинки (width и height)
    
Пример отправляемого массива:
    array('data' => array(
      'userID' => 12345trf,
      'width' => 300,
      'height' => 278
    ))
    
