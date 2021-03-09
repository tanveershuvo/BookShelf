import App from './../../app'
class AuthToken{
    isValid(token){
        const payload = this.payload(token);
        return payload.iss === (App.cons_url + "auth/login");
    }
    payload(token){
        const payload = token.split('.')[1];
        return this.decode(payload);
    }
    decode(payload){
        return JSON.parse(atob(payload));
    }

}
export default AuthToken = new AuthToken()
