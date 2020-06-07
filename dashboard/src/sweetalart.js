import Swal from 'sweetalert2';
let action={
     actionFunction(message,variant,ar){
        Swal.fire(
            `${ar}`+'!',
           `${message}`+'!',
            `${variant}`
            )
    },
}
let confirm={
    confrimFunction(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be logout!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Logout!'
          })
    }
}
export default{
    action,
    confirm
}