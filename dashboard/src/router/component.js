
import Login from "../backendComponents/LoginComponent.vue";
import Home from "../backendComponents/Components/dashboardComponent.vue";
import AboutMe  from "../backendComponents/Components/ProfileComponents/IndexComponent.vue";
import AboutMe_Create  from "../backendComponents/Components/ProfileComponents/CreateComponent.vue";
import AboutMe_Update  from "../backendComponents/Components/ProfileComponents/UpdateComponent.vue";
import Customer  from "../backendComponents/Components/Customers/IndexComponent.vue";
import User  from "../backendComponents/Components/Users/IndexComponent.vue";
import Category  from "../backendComponents/Components/Categorys/IndexComponent.vue";
import SubCategory  from "../backendComponents/Components/SubCategorys/IndexComponent.vue";
import Brand  from "../backendComponents/Components/Brands/IndexComponent.vue";
import Suplier  from "../backendComponents/Components/Supliers/IndexComponent.vue";
import Product  from "../backendComponents/Components/Products/IndexComponent.vue";
import Stock  from "../backendComponents/Components/Stock/IndexComponent.vue";
import Invoice  from "../backendComponents/Components/Invoices/IndexComponent.vue";
import InvoiceCreate  from "../backendComponents/Components/Invoices/CreateComponent.vue";
const routes = [
    {path: "/login",name: "user.login",component: Login },

    {path: "/",name: "dashboard",component: Home },
    {path: "/dashboard",name: "dashboard",component: Home },
    //about me
    {path: "/about-me",name: "about.me",component: AboutMe },
    {path: "/about-me-create",name: "about.create",component: AboutMe_Create },
    {path: "/about-me-update/:id",name: "about.update",component: AboutMe_Update },

    // Customer
    {path: "/customer",name: "customer",component: Customer },
    // User
    {path: "/user",name: "user",component: User },
    // Category
    {path: "/category",name: "category",component: Category },
    // subCategory
    {path: "/sub-category",name: "subCategory",component: SubCategory },
    // subCategorBrandy
    {path: "/brand",name: "brand",component: Brand },
    // Suplier
    {path: "/suplier",name: "suplier",component: Suplier },
    // Product
    {path: "/product",name: "product",component: Product },
    // Stock
    {path: "/stock",name: "stock",component: Stock },
    // Invoice
    {path: "/invoice",name: "invoice",component: Invoice },
    {path: "/invoic-create",name: "invoice.create",component: InvoiceCreate },
   
];
export default routes;