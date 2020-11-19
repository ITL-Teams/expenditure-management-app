import { v4 as uuid } from 'uuid'

export class UserId {
  private readonly value: string

  public constructor(value?: string) {
    this.value = value || this.generateId()
  }

  private generateId(): string {
    return uuid()
  }

  public toString(): string {
    return this.value
  }
}
