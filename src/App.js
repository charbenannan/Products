import "./Pages/App.scss";
import ProductAdd from "./Pages/ProductAdd";
import ProductDetails from "./Pages/ProductDetails";
import Error from "./Pages/Error";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element= { <ProductDetails /> } />
                <Route path="/add-product" element= { <ProductAdd /> } />
                <Route path="*" element= { <Error /> } />
            </Routes>
        </Router>
    );
}
export default App;
