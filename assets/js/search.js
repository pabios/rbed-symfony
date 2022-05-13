document.addEventListener("DOMContentLoaded", function(){
    let resultat = document.querySelector('#resultat');
    let leInput = document.querySelector('#where');
    let datalist = document.querySelector('#datalist');

    // console log resultat apiSearch
    fetch('http://localhost:8000/apiSearch')
        .then(res => {
            if(res.ok){
                console.log("bonjour le toto ");

                return res.json()
            }
        })
        .then(datas =>{
             console.log(datas)
             console.log(datalist);
             datalist.innerHTML = ' ';
             for(let data of datas){
                 //resultat.innerHTML +=`<p> ${dat}</p>`
                datalist.innerHTML+=`<option value="${data}">${data}</option>`
             }
           
            }
        )
       


     
});