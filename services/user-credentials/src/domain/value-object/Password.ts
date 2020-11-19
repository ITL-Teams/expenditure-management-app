const bcrypt = require('bcryptjs')

export class Password {
  private readonly password: string

  public constructor(password: string, encrypt: boolean) {
    if (encrypt) password = bcrypt.hashSync(password, 8)
    this.password = password
  }

  public match(plain_password: Password): boolean {
    return bcrypt.compareSync(plain_password.toString(), this.toString())
  }

  public toString(): string {
    return this.password
  }
}
