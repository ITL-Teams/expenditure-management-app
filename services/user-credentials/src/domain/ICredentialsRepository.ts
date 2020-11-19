import { LoginUser } from './entity/LoginUser'
import { RegisterUser } from './entity/RegisterUser'
import { Email } from './value-object/Email'

export interface ICredentialsRepository {
  create(user: RegisterUser): Promise<void>
  find(email: Email): Promise<LoginUser | null>
}
