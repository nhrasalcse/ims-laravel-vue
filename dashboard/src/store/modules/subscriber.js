import store from '@/store';
const axios = require('axios');
store.subscribe((mutation) =>{
    switch(mutation.type)
    {
        case 'SET_TOKEN':
            // console.log(mutation.payload)
            if(mutation.payload)
       {
           axios.defaults.headers.common['Authorization']=`bearer ${mutation.payload}`
            localStorage.setItem('token',mutation.payload)
        }else{
        axios.defaults.headers.common['Authorization']=null
        localStorage.removeItem('token')
       }

        break;

    }
})