import { expect } from 'chai'
const fetch = require('node-fetch')
import { USER_ID, USER_NAME } from './create-user.test'

// TEST PARAMS
const HTTP_OPTIONS = {
  url: 'http://localhost/user/delete/',
  method: 'delete'
}

// TEST BODY
describe('DELETE USER: /user/delete', function () {
  this.timeout(60000)  

  it('success invocation usign valid id', async () => {
    HTTP_OPTIONS.url += USER_ID

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()
    
    expect(data).to.have.property('success')
    expect(data.success).to.have.property('message')    
    expect(data.success.message).to.be.an('string')

    expect(data.success.message).to.be.equals(
      `User with id = ${USER_ID} was successfully removed`
    )
  })

  it('failed invocation, not valid id', async () => {
    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('error')
    expect(data.error).to.have.property('message')
    expect(data.error).to.have.property('reason')

    expect(data.error.message).to.be.an('string')
    expect(data.error.reason).to.be.an('string')

    expect(data.error.message).to.be.equals('User was not deleted')
    expect(data.error.reason).to.be.equals(
      `UserNotFoundError: User with id = ${USER_ID} does not exist in database`
    )
  })
})
