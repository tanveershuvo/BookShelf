import App from './../../app'
class AuthToken{
    isValid(token){
        const payload = this.payload(token);
        return payload.iss.split('//')[1] === (App.cons_url + "auth/login").split('//')[1]
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
