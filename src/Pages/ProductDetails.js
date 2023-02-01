import React, { useEffect, useState} from "react";
import { useNavigate } from "react-router-dom";
import "./App.scss";
import axios from "axios";

function ProductDetails() {
    const navigate = useNavigate();

    const [products, setProducts] = useState([]);
    const [arraysku, setArraysku] = useState([]);
    const [checkedValues, setValue] = useState([]);

    const handleChange =(e)=>{
        const {value, checked} = e.target;

        setValue(pre =>
             (checked) ? [...pre,value] 
             :
              [...pre.filter(item => item!==value)]);

    }
        

    useEffect(()=>{
        getProducts();
    }, []);

    useEffect(() => {
             products.forEach((product) => { 
            setArraysku((arraysku) => [...arraysku, product.sku]); }); 
        }, [products]);

    const getProducts = ()=> {
    axios.get('http://scand.atwebpages.com/php/index').then(function(response){
    setProducts(response.data);

    });
    }
    
    const deleteButton = () => { 
        axios.delete(`http://scand.atwebpages.com/php/${checkedValues}/index`).then(function(response){

            setValue([]);
            setArraysku([]);

             const checkboxes = document.querySelectorAll('.delete-checkbox');
             checkboxes.forEach(checkbox => checkbox.checked = false);

            getProducts();
        });
    }
   

    return (
        <div className="ProductDetails">
            <header>    
                    <h1>Product List</h1>
                    
                    <button onClick={() => navigate("/add-product")}>ADD</button>
                   
                    <button  onClick={deleteButton} id="delete-product-btn">MASS DELETE</button>
            </header>
                <hr />

            <main>
                <div className="card-holder">
                                  
                    {products.map((product,key) =>
                    <div key={key} className="card">
                        <input type="checkbox" value={product.sku} onChange={handleChange} className="delete-checkbox" />
                    
                        
                        <p>{product.sku}</p>
                        <p>{product.name}</p>
                        <p>${product.price}</p>
                        <p>{product.product_type === "Furniture" ? `Dimensions: ${product.width} x ${product.height} x ${product.length}` :
                         product.product_type === "Book" ? `Weight: ${product.weight}KG` : `Size: ${product.size} MB`}</p>
                        </div>
                    )}
                   

                </div>  
                
            </main>

          
            <hr />           
            <footer> Scandiweb Test Assessment</footer>
        </div>
    );
}

export default ProductDetails;
