const express = require("express");
const app = express();
const port = 3000;
const Data = [
    {
        id:1,
        cost:"$50",
        date:"90",
        img:"https://www.deere.com/assets/images/region-4/products/tractors/row-crop-tractors/row-crop-group/6family-rowcrop-r4b009242-1366.jpg",
        name:"tractor",
        details:"",
        
    }, 
    {
        id:2,
        cost:"$60",
        date:"78",
        img:"https://cf.ltkcdn.net/antiques/images/orig/272739-1600x1066-antique-tractors.jpg",
        name:"tractor",
        details:"",

    }, 
    {
        id:3,
        cost:"$100",
        date:"54",
        img:"https://heritagetractor.com/img/equip_images/1725c-planter_SEOVAL.jpg",
        name:"Planting equipment",
        details:"",
    }, 
    {
        id:4,
        cost:"$65",
        date:"12",
        img:"https://www.ics-agri.com/photos/rapid-seed-drill-sudan-by-ics-consulting-services-invest-in-profitable-agriculture-800p.jpg",
        name:"Seed drills",
        details:"",
    }, 
    {
        id:5,
        cost:"$98",
        date:"45",
        img:"https://blog.machinefinder.com/wp-content/uploads/2020/05/1890_no_till_air_drill_field_standard_r4d003253_large_4306a8dbd7647734661da6a0adc459fccf65a1d2.jpg",
        name:"Planting equipment",
        details:"",
    }, 
    {
        id:6,
        cost:"$92",
        date:"156",
        img:"https://www.rbauction.com/cms_assets/category_images/13633930728/13633930728_W_S.jpg",
        name:"seed drills",
        details:"",
    }, 
    {
        id:7,
        cost:"$119",
        date:"114",
        img:"https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_848,h_565/https://www.futurefarming.com/app/uploads/2021/06/001_150_IMG_AmazonePrecea600001-848x565.jpg",
        name:"seed planters",
        details:"",
    }, 
    {
        id:8,
        cost:"$89",
        date:"98",
        img:"https://www.johnnyseeds.com/dw/image/v2/BJGJ_PRD/on/demandware.static/-/Library-Sites-JSSSharedLibrary/default/dw15418045/images/catbanner/tools/transplanters_bn.jpg?sw=920",
        name:"transplanters",
        details:"",
    }, 
    {
        id:9,
        cost:"$17",
        date:"46",
        img:"https://cdn3.volusion.com/wf72e.9ho5t/v/vspfiles/photos/COLE-12MX-2.jpg?v-cache=1665468964",
        name:"Seed Planters",
        details:"",
    }, 
    {
        id:10,
        cost:"$79",
        date:"43",
        img:"https://water.unl.edu/redesign/teaser-crop-production.jpg",
        name:"Crop protection",
        details:"",
    }, 
    {
        id:11,
        cost:"$200",
        date:"61",
        img:"https://cdn11.bigcommerce.com/s-9ppxt2hq56/images/stencil/1280x1280/products/215/1336/swissmex-acetone-sprayer__16473.1679076866.jpg?c=1",
        name:"sprayers",
        details:"",
    }, 
    {
        id:12,
        cost:"$150",
        date:"48",
        img:"https://www.echo-usa.com/getattachment/ad861d42-5223-4bc0-bd76-63f90c19f8ac/v2_spreaders_400X400.jpg",
        name:"spreaders",
        details:"",
    }, 
    {
        id:13,
        cost:"$76",
        date:"93",
        img:"https://www.granodirect.com.au/image/cache/catalog/products/60-tools/120-sprayers/swissmex-pressure-sprayer-acetone-9l-800x600.jpg",
        name:"sprayers",
        details:"",
    }, 
    {
        id:14,
        cost:"$94",
        date:"11",
        img:"https://www.nigelquinnams.co.uk/wp-content/uploads/2020/01/9-row-planter1-2.jpg",
        name:"transplanters",
        details:""


    },
    
    
    ];
    
app.set('view engine', 'ejs');
app.use(express.static('./public'));
app.get('/home', (req,res)=>{
    res.render('landing');
});

app.get('/choice', (req, res)=>{
    res.render('choice')
});
const account = [];
app.get('/login', (req, res)=>{
    res.render('login');
    signIn(account);
});


app.get('/signup', (req, res)=>{
    res.render('signup');
    createAccount(account);
});

app.get('/render', (req, res)=>{
    res.render('renters', {data:Data});
});

app.get('/lender', (req, res)=>{
    res.render('lenters', {data:Data});

});

app.get('/checkout', (req, res)=>{
    res.render('checkout', {data:Data});
});

app.get('/details', (req, res)=>{
    res.render('details', {data:Data});
});

const ItemClicked = ()=>{
    app.get('/details', (req, res)=>{
        res.render('details', {data:Data});
    });
}
// const ItemClicked = ()=>{
    
// }
// let uploadBtn = document.getElementById("#file-upload");
// uploadBtn.addEventListener("change", changeBG);
// function changeBG() {
//   let reader;
//   if (this.files && this.files[0]) {
//     reader = new FileReader();
//     reader.onload = (e) => {
//       bgObject.img.src = e.target.result;
//       drawCanvas();
//     };
//     reader.readAsDataURL(this.files[0]);
//   }
// }



app.listen(port, ()=> {
    console.log("The app is running on server 3000");
})



//const Items = document.querySelector(".items");

// data.forEach((item)=>{
//     const container = document.createElement("div");
//     container.classList.add("theItems");

//     const ImgContainer = document.createElement("div");
//     ImgContainer.style.backgroundImage = `url{${item.img}}`
//     ImgContainer.style.width="60px";
//     ImgContainer.style.height="60px";

//     const name = document.createElement("p");
//     name.style.innerHtml = item.name;

//     const cost = document.createElement("p");
//     cost.style.innerHtml = item.cost;

//     const days = document.createElement("p");
//     days.style.innerHtml = item.date;

//     container.appendChild(name);
//     container.appendChild(cost);
//     container.appendChild(days);
//     Items.appendChild(container);

// })