import { expect } from 'chai'
const fetch = require('node-fetch')
import { USER_ID, USER_NAME } from './create-user.test'

// TEST PARAMS
const HTTP_OPTIONS = {
  url: 'http://localhost/user/get/',
  method: 'get'
}

// TEST BODY
describe('GET USER: /user/get', function () {
  this.timeout(60000)  

  it('success invocation usign valid id', async () => {
    HTTP_OPTIONS.url += USER_ID

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()
    
    expect(data).to.have.property('success')
    expect(data.success).to.have.property('user')
    expect(data.success.user).to.have.property('id')
    expect(data.success.user).to.have.property('name')
    
    expect(data.success.user.id).to.be.an('string')
    expect(data.success.user.name).to.be.an('string')

    expect(data.success.user.id).to.be.equals(USER_ID)
    expect(data.success.user.name).to.be.equals(USER_NAME)
  })

  it('failed invocation, not valid id', async () => {
    HTTP_OPTIONS.url += '2'

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('error')
    expect(data.error).to.have.property('message')
    expect(data.error).to.have.property('reason')

    expect(data.error.message).to.be.an('string')
    expect(data.error.reason).to.be.an('string')

    expect(data.error.message).to.be.equals('User not found')
    expect(data.error.reason).to.be.equals(
      `UserNotFoundError: with userId = ${ USER_ID }2`
    )
  })
})
