
console.log('mamamiya');


document.addEventListener("DOMContentLoaded", function(){

console.log('mamamiya');
console.log(route);
fetch(route)
.then(res =>{
    if(res.ok){
        return res.json();
    }
})
.then(
    console.log('bonjour data')
)

 });