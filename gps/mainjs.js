ymaps.ready(init);

function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function mins0(dt) 
{ 
  return (dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes();
}

function get_couriers(myMap)
{
    var json = JSON.parse(httpGet("http://partum-logistic.ru/gps/geo.json"))
    for (var var4 in json) {
        var d = new Date(json[var4].update*1000)
        var now = new Date()
        
        //if(var4.length!=11)var4="11111111111"
        order = httpGet("http://partum-logistic.ru/gps/getname.php?e=order&phone="+var4)

        var preset_color = "islands#greenCircleIcon"
        var ru_status = "Свободен"

        if(order=="hack!")
        {
            preset_color = 'islands#nightCircleIcon'  
            ru_status = "Неизвестно"
        }
        else
        {
            order = JSON.parse(order)
            
            if(order.status=="order_taken")
            {
                ru_status = "Принял заявку"
                preset_color = "islands#yellowCircleIcon"
            }
            else if(order.status=="items_taken")
            {
                ru_status = "Везет заказ"
                preset_color = "islands#lightBlueCircleDotIcon"
            }

            if(order.late==1)
            {
                ru_status = "Курьер опаздывает"
                preset_color = "islands#redCircleDotIcon"
            }
        }

        var ballcontent = ""
        if ( d.valueOf()<now.valueOf()-(20*60*1000) )
        {
            preset_color = 'islands#grayCircleDotIcon'
            ballcontent = ballcontent+"Связь потеряна "+d.getDate()+"."+d.getMonth()+"."+d.getFullYear()+" в "+(d.getHours() + ":"+mins0(d))
        }
        else
        {
            ballcontent=ballcontent+"Телефон: +"+ (var4) + "<br>"
            ballcontent=ballcontent+"Статус: "+ ru_status + "<br>"
            //ballcontent=ballcontent+"Speed?: "+(json[var4].speed) + "<br>"
            ballcontent=ballcontent+"Точность: "+ (+json[var4].acc).toFixed(1) + "м<br>"
            //ballcontent=ballcontent+"Последние обновление: "+(d.getHours() + ":"+mins0(d))
        }

        var usrname = httpGet("http://partum-logistic.ru/gps/getname.php?phone="+var4)
        if(usrname=="hack!")usrname=var4
        var ballhead = usrname + " [" + json[var4].batt + "%]"
        var ballfooter = "Последние обновление: "+(d.getHours() + ":"+mins0(d))
        
        myMap.geoObjects.add(new ymaps.Placemark([json[var4].lat, json[var4].lon],
            {
                balloonContentHeader: ballhead,
                balloonContentBody: ballcontent,
                balloonContentFooter : ballfooter,
            },
            {
                preset: preset_color
            }
        ));

    }
}


function get_orders(myMap)
{
    var json = JSON.parse(httpGet("http://partum-logistic.ru/gps/getname.php?e=orders"))
    var ADRSS = {};
    for (var i in json) {
        var elem = json[i]
        var address_from = elem[3]
        var address_to = elem[5]
        var name = elem[30]
        var id = elem[0]
        var when = elem[11]
        
        if (ADRSS[address_from]==null)ADRSS[address_from]="<b>"+name+"</b> ("+address_from+")"
        var strike = ""
        var strike_out = ""
        if (elem[19]!="0")
        {
            strike="<s>"
            strike_out = "</s>"
        }
        ADRSS[address_from] = ADRSS[address_from] + "<br>" + strike + "[" + id + "] " + address_to + " (" +when+")" + strike_out
    }

    for (var i in ADRSS) {

        ymaps.geocode(i, {
            results: 1,
            boundedBy: myMap.getBounds(),
            strictBounds: true,
        }).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates()
            myMap.geoObjects.add(new ymaps.Placemark([coords[0], coords[1]],
                {
                    balloonContent: ADRSS[res.metaData.geocoder.request]
                },
                {
                    preset: 'islands#blueDeliveryIcon'
                }
            ));
        })
    }
}

function up2date(myMap)
{
    myMap.geoObjects.removeAll()
    get_couriers(myMap)
    get_orders(myMap)
    setTimeout(function(){up2date(myMap)}, 30*1000);
}

function init() {
    var myMap = new ymaps.Map("map", {
        center: [55.030199,82.920430],
        zoom: 13
    }, {
        searchControlProvider: 'yandex#search'
    });


    up2date(myMap);
    

}
