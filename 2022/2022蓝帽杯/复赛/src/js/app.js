
import React from 'react';
import ReactDom from 'react-dom';


export function ListBox(props) {
    
    return (
        <ul>
            {props.arr.map((item)=>
            
            (
            <><div className='menu'>
                <a href="#">{item.name}</a>
            </div>
            <div className='list-box'>
            <a href="#">{item.cl}</a>
            </div>
            </>
            
            )
            
            )}
        </ul>
          
    );
}

const data = "https://raw.githubusercontent.com/jameskerry651/bus_data/main/diagnose.json";


function request_get() {
    var httpRequest = new XMLHttpRequest();	// 第一步：建立所需的对象
    httpRequest.open('GET', data, true);	// 第二步：打开连接，将请求参数写在url中
    httpRequest.send();	// 第三步：发送请求，将请求参数写在URL中
    // 获取数据后的处理程序
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
            var json = httpRequest.responseText; //获取到json字符串，还需解析
            json = JSON.parse(json);
            console.log(json);
            const element = <ListBox arr = {json}/>

            ReactDom.render(
                element,
                document.getElementById("nav_id")
            );
        }
    };
}

request_get();



