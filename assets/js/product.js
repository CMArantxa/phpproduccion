$("#cart").click(()=>{
    
    if($("#user").html()==""){
        e.preventDefault();
        //hay que logearse
        $("#modal-login").modal("show");
    }
}
);