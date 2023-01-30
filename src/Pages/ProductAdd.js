import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./App.scss";
import axios from "axios";


function ProductAdd() {
    const navigate = useNavigate();
    
    const[inputs, setInputs] = useState({});
     

    const maintainChange = (e) =>{
        const name = e.target.name;
        const value = e.target.value;
        
        setInputs(values => ({...values, [name]: value}));
    };
   
    
    const handleSubmit= (e) =>{
        const productTypeValidators = {
            DVD: function(inputs) {
              return !isNaN(inputs.size);
            },
            Furniture: function(inputs) {
              return !isNaN(inputs.height) && !isNaN(inputs.width) && !isNaN(inputs.length);
            },
            Book: function(inputs) {
              return !isNaN(inputs.weight);
            },
          }
          
          if (!inputs.sku || !inputs.name || !inputs.price || !inputs.productType) {
            document.getElementById("notification").innerHTML = "Please, submit required data";
            return;
          }
          
          const isValidProductType = productTypeValidators[inputs.productType];
          if (!isValidProductType || !isValidProductType(inputs)) {
            document.getElementById("notification").innerHTML = "Please, provide the data of indicated type";
            return;
          }
          
        axios.post('http://localhost:8082/php/index', inputs).then(function(response){
           
            if(response.data.message === 'This product has already been added'){
                document.getElementById("notification").innerHTML = "SKU already exists, please add another product or correct the sku";
                return;
            }
            navigate('/');
            
        });

     }  

    return (
        <div className="App">
            <header>
                <h1>Product Add</h1>  
                <button type="submit" onClick={handleSubmit}>Save</button>
                <button onClick={() => navigate("/")}>Cancel</button>
            </header>
            <hr />

            <main>
            <div id="notification"></div>
                <form id="product_form" onSubmit={handleSubmit}>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <label htmlFor="sku">SKU</label>
                                </td>
                                <td>
                                    <input type="text" name="sku" id="sku" onChange={maintainChange} required/>
                                </td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <td>
                                    <label htmlFor="name">Name</label>
                                </td>
                                <td>
                                    <input type="text" name="name" id="name"  onChange={maintainChange} required/>
                                </td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <td>
                                    <label htmlFor="price">Price ($)</label>
                                </td>
                                <td>
                                    <input type="number" name="price"id="price" onChange={maintainChange} required/>
                                </td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <td>
                                    <label htmlFor="productType">Type Switcher</label>
                                </td>
                                <td>
                                    <select
                                        name="productType"
                                        id="productType"
                                        value={inputs.productType}
                                        onChange={maintainChange}
                                        
                                    >
                                        <option value=""></option>
                                        <option value="DVD">DVD</option>
                                        <option value="Book">Book</option>
                                        <option value="Furniture">Furniture</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        id="DVD"
                        style={{
                            display: inputs.productType === "DVD" ? "block" : "none"
                        }}
                    >
                    <tbody>
                        <label htmlFor="size">Size(MB)</label>
                        <input type="number" name="size" id="size" onChange={maintainChange} required/>
                        <p>Please provide the size of the DVD-disc in Megabytes</p>
                        </tbody>
                    </div>

                    <div
                        id="Furniture"
                        style={{
                            display:
                                inputs.productType === "Furniture" ? "block" : "none"
                        }}
                    >
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label htmlFor="height"> Height(CM)</label>
                                    </td>
                                    <td>
                                        <input type="number" name="height" id="height" onChange={maintainChange} required/>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>
                                        <label htmlFor="width">Width(CM)</label>
                                    </td>
                                    <td>
                                        <input type="number" name="width" id="width" onChange={maintainChange} required/>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>
                                        <label htmlFor="length"> Length(CM)</label>
                                    </td>
                                    <td>
                                        <input type="number" name="length" id="length" onChange={maintainChange} required/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Please provide dimensions in HxWxL htmlFormat</p>
                    </div>

                    <div
                        id="Book"
                        style={{
                            display: inputs.productType === "Book" ? "block" : "none"
                        }}
                    >
                        <tbody>
                        <label htmlFor="weight">Weigth(KG)</label>
                        <input type="number" name="weight" id="weight" onChange={maintainChange} required/>

                        <p>Please provide the weight in Kilogram</p>
                        </tbody>
                    </div>
                </form>
            </main>

            <hr />

            <footer>Scandiweb Test Assessment</footer>
        </div>
    );
}
export default ProductAdd;
